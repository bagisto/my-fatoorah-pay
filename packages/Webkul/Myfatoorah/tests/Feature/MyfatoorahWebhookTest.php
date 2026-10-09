<?php

use Webkul\Myfatoorah\Http\WebhookSignature;
use Webkul\Myfatoorah\Payment\Myfatoorah;
use Webkul\Sales\Models\Order;

/**
 * The webhook v2 PAYMENT_STATUS_CHANGED body MyFatoorah posts, in the shape `webhook()` reads.
 */
function myfatoorahWebhookPayload(string $cartId, string $paymentId, array $overrides = []): array
{
    return array_merge([
        'Event' => ['Code' => 1, 'Name' => 'PAYMENT_STATUS_CHANGED'],
        'Data' => [
            'Invoice' => ['Id' => 'inv-1', 'Status' => 'PAID', 'ExternalIdentifier' => $cartId],
            'Transaction' => ['Id' => 'txn-1', 'Status' => 'SUCCESS', 'PaymentMethod' => 'KNET', 'PaymentId' => $paymentId],
            'Customer' => ['Reference' => $cartId],
            'Amount' => ['ValueInDisplayCurrency' => 100, 'DisplayCurrency' => 'USD'],
        ],
    ], $overrides);
}

/**
 * Sign a webhook payload the same way `WebhookSignature::isValid()` verifies it.
 */
function myfatoorahWebhookSignature(array $payload, string $secretKey): string
{
    $invoice = $payload['Data']['Invoice'] ?? [];

    $transaction = $payload['Data']['Transaction'] ?? [];

    return base64_encode(hash_hmac('sha256', implode(',', [
        'InvoiceId='.($invoice['Id'] ?? ''),
        'InvoiceStatus='.($invoice['Status'] ?? ''),
        'TransactionId='.($transaction['Id'] ?? ''),
        'TransactionStatus='.($transaction['Status'] ?? ''),
    ]), $secretKey, true));
}

beforeEach(function () {
    $this->setConfig([
        'sales.payment_methods.myfatoorah.active' => '1',
        'sales.payment_methods.myfatoorah.is_webhook_enabled' => '1',
        'sales.payment_methods.myfatoorah.webhook_secret_key' => 'test-secret',
    ]);

    $this->myfatoorahMock = $this->mock(Myfatoorah::class)->makePartial();

    $this->myfatoorahMock->shouldReceive('getCurrency')->andReturn('USD');

    $this->myfatoorahMock->shouldReceive('getCurrencyDecimal')->andReturn(2);

    $this->app->instance(Myfatoorah::class, $this->myfatoorahMock);
});

// ============================================================================
// Signature
// ============================================================================

it('should reject a webhook with no signature header', function () {
    $response = $this->postJson(route('myfatoorah.webhook'), myfatoorahWebhookPayload('1', 'pay-1'));

    $response->assertStatus(404)->assertJson(['status' => 'invalid_signature']);
});

it('should reject a webhook signed with the wrong secret', function () {
    $payload = myfatoorahWebhookPayload('1', 'pay-1');

    $response = $this->withHeaders(['MyFatoorah-Signature' => myfatoorahWebhookSignature($payload, 'wrong-secret')])
        ->postJson(route('myfatoorah.webhook'), $payload);

    $response->assertStatus(404)->assertJson(['status' => 'invalid_signature']);
});

it('should respond that the webhook is disabled when no secret key is configured', function () {
    $this->setConfig('sales.payment_methods.myfatoorah.webhook_secret_key', '');

    $payload = myfatoorahWebhookPayload('1', 'pay-1');

    $response = $this->withHeaders(['MyFatoorah-Signature' => myfatoorahWebhookSignature($payload, 'test-secret')])
        ->postJson(route('myfatoorah.webhook'), $payload);

    $response->assertStatus(404)->assertJson(['status' => 'webhook_disabled']);
});

// ============================================================================
// Settlement
// ============================================================================

it('should place the order from a correctly signed webhook', function () {
    $cart = $this->createCartWithItems('myfatoorah');

    $payload = myfatoorahWebhookPayload((string) $cart->id, 'pay-1', [
        'Data' => [
            'Invoice' => ['Id' => 'inv-1', 'Status' => 'PAID', 'ExternalIdentifier' => (string) $cart->id],
            'Transaction' => ['Id' => 'txn-1', 'Status' => 'SUCCESS', 'PaymentMethod' => 'KNET', 'PaymentId' => 'pay-1'],
            'Customer' => ['Reference' => (string) $cart->id],
            'Amount' => ['ValueInDisplayCurrency' => (float) $cart->grand_total, 'DisplayCurrency' => $cart->cart_currency_code],
        ],
    ]);

    $this->myfatoorahMock->shouldReceive('getPaymentDetails')->with('pay-1')->andReturn($payload['Data']);

    $response = $this->withHeaders(['MyFatoorah-Signature' => myfatoorahWebhookSignature($payload, 'test-secret')])
        ->postJson(route('myfatoorah.webhook'), $payload);

    $response->assertJson(['status' => 'order_placed']);

    expect(Order::query()->where('cart_id', $cart->id)->count())->toBe(1);
});

it('should ignore an event that is not a payment status change', function () {
    $payload = myfatoorahWebhookPayload('1', 'pay-1', ['Event' => ['Code' => 2, 'Name' => 'REFUND_STATUS_CHANGED']]);

    $response = $this->withHeaders(['MyFatoorah-Signature' => myfatoorahWebhookSignature($payload, 'test-secret')])
        ->postJson(route('myfatoorah.webhook'), $payload);

    $response->assertJson(['status' => 'ignored']);
});

it('should not duplicate an order the callback already placed', function () {
    $cart = $this->createCartWithItems('myfatoorah');

    $data = [
        'Invoice' => ['Id' => 'inv-1', 'Status' => 'PAID', 'ExternalIdentifier' => (string) $cart->id],
        'Transaction' => ['Id' => 'txn-1', 'Status' => 'SUCCESS', 'PaymentMethod' => 'KNET', 'PaymentId' => 'pay-1'],
        'Customer' => ['Reference' => (string) $cart->id],
        'Amount' => ['ValueInDisplayCurrency' => (float) $cart->grand_total, 'DisplayCurrency' => $cart->cart_currency_code],
    ];

    $this->myfatoorahMock->shouldReceive('getPaymentDetails')->with('pay-1')->andReturn($data);

    $this->get(route('myfatoorah.callback', ['paymentId' => 'pay-1']));

    $payload = myfatoorahWebhookPayload((string) $cart->id, 'pay-1', ['Data' => $data]);

    $this->withHeaders(['MyFatoorah-Signature' => myfatoorahWebhookSignature($payload, 'test-secret')])
        ->postJson(route('myfatoorah.webhook'), $payload);

    expect(Order::query()->where('cart_id', $cart->id)->count())->toBe(1);
});

it('isValid() verifies a signature computed the same way', function () {
    $payload = myfatoorahWebhookPayload('1', 'pay-1');

    $signature = myfatoorahWebhookSignature($payload, 'shared-secret');

    expect(WebhookSignature::isValid($payload, 'shared-secret', $signature))->toBeTrue()
        ->and(WebhookSignature::isValid($payload, 'different-secret', $signature))->toBeFalse();
});
