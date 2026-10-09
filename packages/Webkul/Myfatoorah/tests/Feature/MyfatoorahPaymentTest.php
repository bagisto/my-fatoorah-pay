<?php

use Webkul\Checkout\Facades\Cart;
use Webkul\Myfatoorah\Payment\Myfatoorah;
use Webkul\Sales\Models\Invoice;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Models\OrderTransaction;

/**
 * The `Data` object `getPaymentDetails()` really returns for a paid payment.
 */
function myfatoorahPaymentDetails($cart, array $overrides = []): array
{
    return array_merge([
        'Invoice' => ['Id' => 'inv-1', 'Status' => 'PAID', 'ExternalIdentifier' => (string) $cart->id],
        'Transaction' => ['Id' => 'txn-1', 'Status' => 'SUCCESS', 'PaymentMethod' => 'KNET', 'PaymentId' => 'pay-1'],
        'Customer' => ['Reference' => (string) $cart->id],
        'Amount' => ['ValueInDisplayCurrency' => (float) $cart->grand_total, 'DisplayCurrency' => $cart->cart_currency_code],
    ], $overrides);
}

beforeEach(function () {
    $this->setConfig([
        'sales.payment_methods.myfatoorah.active' => '1',
        'sales.payment_methods.myfatoorah.api_key' => 'test-key',
        'sales.payment_methods.myfatoorah.test_mode' => '1',
        'sales.payment_methods.myfatoorah.country_iso' => 'KWT',
    ]);

    $this->myfatoorahMock = $this->mock(Myfatoorah::class)->makePartial();

    $this->app->instance(Myfatoorah::class, $this->myfatoorahMock);
});

// ============================================================================
// Redirect
// ============================================================================

it('should redirect to the cart when credentials are not configured', function () {
    $myfatoorahMock = $this->mock(Myfatoorah::class)->makePartial();

    $myfatoorahMock->shouldReceive('hasValidCredentials')->andReturn(false);

    $this->app->instance(Myfatoorah::class, $myfatoorahMock);

    $response = $this->get(route('myfatoorah.redirect'));

    $response->assertRedirect(route('shop.checkout.cart.index'));

    $response->assertSessionHas('error');
});

it('should redirect to the cart when the cart is not found', function () {
    $this->myfatoorahMock->shouldReceive('hasValidCredentials')->andReturn(true);

    Cart::shouldReceive('getCart')->andReturn(null);

    $response = $this->get(route('myfatoorah.redirect'));

    $response->assertRedirect(route('shop.checkout.cart.index'));

    $response->assertSessionHas('error');
});

it('should send the customer to the hosted payment page without recording anything of its own', function () {
    $cart = $this->createCartWithItems('myfatoorah');

    $this->myfatoorahMock->shouldReceive('hasValidCredentials')->andReturn(true);

    Cart::shouldReceive('getCart')->andReturn($cart);

    $this->myfatoorahMock->shouldReceive('createPayment')
        ->andReturn(['PaymentURL' => 'https://pay.myfatoorah.com/abc']);

    $response = $this->get(route('myfatoorah.redirect'));

    $response->assertRedirect('https://pay.myfatoorah.com/abc');

    expect(Order::query()->where('cart_id', $cart->id)->exists())->toBeFalse();
});

it('should report a failure when myfatoorah will not start the payment', function () {
    $cart = $this->createCartWithItems('myfatoorah');

    $this->myfatoorahMock->shouldReceive('hasValidCredentials')->andReturn(true);

    Cart::shouldReceive('getCart')->andReturn($cart);

    $this->myfatoorahMock->shouldReceive('createPayment')->andReturn(null);

    $response = $this->get(route('myfatoorah.redirect'));

    $response->assertRedirect(route('shop.checkout.cart.index'));

    $response->assertSessionHas('error');
});

// ============================================================================
// Callback
// ============================================================================

it('should settle the payment and create the order with an invoice from the callback', function () {
    $cart = $this->createCartWithItems('myfatoorah');

    $this->myfatoorahMock->shouldReceive('getPaymentDetails')
        ->with('pay-1')
        ->andReturn(myfatoorahPaymentDetails($cart));

    $this->myfatoorahMock->shouldReceive('getCurrency')->andReturn($cart->cart_currency_code);

    $this->myfatoorahMock->shouldReceive('getCurrencyDecimal')->andReturn(2);

    $response = $this->get(route('myfatoorah.callback', ['paymentId' => 'pay-1']));

    $response->assertRedirect(route('shop.checkout.onepage.success'));

    $order = Order::query()->where('cart_id', $cart->id)->first();

    expect($order)->not->toBeNull()
        ->and($order->status)->toBe('processing');

    $orderTransaction = OrderTransaction::query()->where('transaction_id', 'txn-1')->first();

    expect($orderTransaction)->not->toBeNull()
        ->and($orderTransaction->order_id)->toBe($order->id)
        ->and($orderTransaction->status)->toBe('SUCCESS')
        ->and(Invoice::query()->where('order_id', $order->id)->first())->not->toBeNull()
        ->and($cart->refresh()->is_active)->toBeFalse();
});

it('should not create an order when myfatoorah does not report the payment as paid', function () {
    $cart = $this->createCartWithItems('myfatoorah');

    $this->myfatoorahMock->shouldReceive('getPaymentDetails')
        ->andReturn(myfatoorahPaymentDetails($cart, ['Invoice' => ['Id' => 'inv-1', 'Status' => 'PENDING']]));

    $response = $this->get(route('myfatoorah.callback', ['paymentId' => 'pay-1']));

    $response->assertRedirect(route('shop.checkout.cart.index'));

    $response->assertSessionHas('error');

    expect(Order::query()->where('cart_id', $cart->id)->exists())->toBeFalse();
});

it('should settle the same payment only once however many times it is confirmed', function () {
    $cart = $this->createCartWithItems('myfatoorah');

    $this->myfatoorahMock->shouldReceive('getPaymentDetails')
        ->andReturn(myfatoorahPaymentDetails($cart));

    $this->myfatoorahMock->shouldReceive('getCurrency')->andReturn($cart->cart_currency_code);

    $this->myfatoorahMock->shouldReceive('getCurrencyDecimal')->andReturn(2);

    $this->get(route('myfatoorah.callback', ['paymentId' => 'pay-1']));

    $this->get(route('myfatoorah.callback', ['paymentId' => 'pay-1']));

    expect(Order::query()->where('cart_id', $cart->id)->count())->toBe(1);
});
