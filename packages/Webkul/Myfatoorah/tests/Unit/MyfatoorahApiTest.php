<?php

use Illuminate\Support\Facades\Http;
use Webkul\Myfatoorah\Payment\Myfatoorah;

/**
 * A cart stub with just the fields `createPayment()` reads off it.
 */
function myfatoorahCartStub(array $overrides = []): object
{
    return (object) array_merge([
        'id' => 7,
        'grand_total' => 10.5,
        'cart_currency_code' => 'KWD',
        'customer_email' => 'customer@example.com',
        'customer_first_name' => 'Jane',
        'customer_last_name' => 'Doe',
        'billing_address' => null,
    ], $overrides);
}

beforeEach(function () {
    Http::preventStrayRequests();

    $this->setConfig([
        'sales.payment_methods.myfatoorah.api_key' => 'test-key',
        'sales.payment_methods.myfatoorah.test_mode' => '1',
    ]);

    $this->myfatoorah = app(Myfatoorah::class);
});

// ============================================================================
// Create Payment
// ============================================================================

it('returns the payment url on a successful create payment call', function () {
    Http::fake([
        'apitest.myfatoorah.com/v3/payments' => Http::response([
            'IsSuccess' => true,
            'Data' => ['InvoiceId' => '123', 'PaymentId' => null, 'PaymentURL' => 'https://pay.myfatoorah.com/abc'],
        ], 201),
    ]);

    $data = $this->myfatoorah->createPayment(myfatoorahCartStub(), 'https://store/myfatoorah/redirect', 'https://store/myfatoorah/webhook');

    expect($data['PaymentURL'])->toBe('https://pay.myfatoorah.com/abc');

    Http::assertSent(fn ($request) => $request->url() === 'https://apitest.myfatoorah.com/v3/payments'
        && $request->hasHeader('Authorization', 'Bearer test-key')
        && $request['Order']['Amount'] === 10.5
        && $request['Order']['Currency'] === 'KWD'
        && $request['Order']['ExternalIdentifier'] === '7'
        && $request['IntegrationUrls']['Redirection'] === 'https://store/myfatoorah/redirect'
        && $request['IntegrationUrls']['Webhook'] === 'https://store/myfatoorah/webhook');
});

it('never restricts the hosted page to one payment method', function () {
    Http::fake(['apitest.myfatoorah.com/v3/payments' => Http::response([
        'IsSuccess' => true,
        'Data' => ['PaymentURL' => 'https://pay.myfatoorah.com/abc'],
    ], 201)]);

    $this->myfatoorah->createPayment(myfatoorahCartStub(), 'https://store/myfatoorah/redirect', null);

    Http::assertSent(fn ($request) => ! array_key_exists('PaymentMethod', $request->data())
        && ! array_key_exists('DisplayPaymentMethods', $request->data()));
});

it('returns null when myfatoorah reports the create payment call failed', function () {
    Http::fake(['apitest.myfatoorah.com/v3/payments' => Http::response(['IsSuccess' => false, 'Message' => 'bad request'], 400)]);

    expect($this->myfatoorah->createPayment(myfatoorahCartStub(), 'https://store/myfatoorah/redirect', null))->toBeNull();
});

it('returns null when myfatoorah does not report a payment url', function () {
    Http::fake(['apitest.myfatoorah.com/v3/payments' => Http::response(['IsSuccess' => true, 'Data' => []], 201)]);

    expect($this->myfatoorah->createPayment(myfatoorahCartStub(), 'https://store/myfatoorah/redirect', null))->toBeNull();
});

// ============================================================================
// Get Payment Details
// ============================================================================

it('returns the data object for a known payment', function () {
    Http::fake(['apitest.myfatoorah.com/v3/payments/pay-1' => Http::response([
        'IsSuccess' => true,
        'Data' => ['Invoice' => ['Status' => 'PAID']],
    ], 200)]);

    $data = $this->myfatoorah->getPaymentDetails('pay-1');

    expect($data['Invoice']['Status'])->toBe('PAID');
});

it('returns null when myfatoorah reports failure for get payment details', function () {
    Http::fake(['apitest.myfatoorah.com/*' => Http::response(['IsSuccess' => false], 404)]);

    expect($this->myfatoorah->getPaymentDetails('unknown'))->toBeNull();
});

// ============================================================================
// Create Refund
// ============================================================================

it('sends the payment id and amount to create refund', function () {
    Http::fake(['apitest.myfatoorah.com/v3/refunds' => Http::response([
        'IsSuccess' => true,
        'Data' => ['Refund' => ['Status' => 'Pending']],
    ], 201)]);

    $data = $this->myfatoorah->createRefund('pay-1', 10.5, 'refund-9');

    expect($data['Refund']['Status'])->toBe('Pending');

    Http::assertSent(fn ($request) => $request->url() === 'https://apitest.myfatoorah.com/v3/refunds'
        && $request['PaymentId'] === 'pay-1'
        && $request['Amount'] === 10.5
        && $request['ExternalIdentifier'] === 'refund-9');
});

it('returns null when myfatoorah refuses the refund', function () {
    Http::fake(['apitest.myfatoorah.com/v3/refunds' => Http::response(['IsSuccess' => false, 'Message' => 'already refunded'], 400)]);

    expect($this->myfatoorah->createRefund('pay-1', 10.5, 'refund-9'))->toBeNull();
});
