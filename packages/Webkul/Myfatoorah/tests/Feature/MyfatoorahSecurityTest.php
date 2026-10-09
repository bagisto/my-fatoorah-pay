<?php

use Webkul\Myfatoorah\Payment\Myfatoorah;
use Webkul\Sales\Models\Order;

beforeEach(function () {
    $this->myfatoorahMock = $this->mock(Myfatoorah::class)->makePartial();

    $this->app->instance(Myfatoorah::class, $this->myfatoorahMock);
});

it('should reject a callback with a malformed paymentId', function () {
    $this->myfatoorahMock->shouldNotReceive('getPaymentDetails');

    $response = $this->get(route('myfatoorah.callback', ['paymentId' => '<script>alert(1)</script>']));

    $response->assertRedirect(route('shop.checkout.cart.index'));

    $response->assertSessionHas('error');
});

it('should reject a callback with no paymentId at all', function () {
    $this->myfatoorahMock->shouldNotReceive('getPaymentDetails');

    $response = $this->get(route('myfatoorah.callback'));

    $response->assertRedirect(route('shop.checkout.cart.index'));

    $response->assertSessionHas('error');
});

it('should not place an order when the amount myfatoorah reports does not match the cart', function () {
    $cart = $this->createCartWithItems('myfatoorah');

    $this->myfatoorahMock->shouldReceive('getPaymentDetails')->andReturn([
        'Invoice' => ['Id' => 'inv-1', 'Status' => 'PAID', 'ExternalIdentifier' => (string) $cart->id],
        'Transaction' => ['Id' => 'txn-1', 'Status' => 'SUCCESS', 'PaymentMethod' => 'KNET', 'PaymentId' => 'pay-1'],
        'Customer' => ['Reference' => (string) $cart->id],
        'Amount' => ['ValueInDisplayCurrency' => (float) $cart->grand_total + 50, 'DisplayCurrency' => $cart->cart_currency_code],
    ]);

    $this->myfatoorahMock->shouldReceive('getCurrency')->andReturn($cart->cart_currency_code);

    $this->myfatoorahMock->shouldReceive('getCurrencyDecimal')->andReturn(2);

    $response = $this->get(route('myfatoorah.callback', ['paymentId' => 'pay-1']));

    $response->assertRedirect(route('shop.checkout.cart.index'));

    expect(Order::query()->where('cart_id', $cart->id)->exists())->toBeFalse();
});

it('should not place an order when myfatoorah reports a different currency than the cart', function () {
    $cart = $this->createCartWithItems('myfatoorah');

    $this->myfatoorahMock->shouldReceive('getPaymentDetails')->andReturn([
        'Invoice' => ['Id' => 'inv-1', 'Status' => 'PAID', 'ExternalIdentifier' => (string) $cart->id],
        'Transaction' => ['Id' => 'txn-1', 'Status' => 'SUCCESS', 'PaymentMethod' => 'KNET', 'PaymentId' => 'pay-1'],
        'Customer' => ['Reference' => (string) $cart->id],
        'Amount' => ['ValueInDisplayCurrency' => (float) $cart->grand_total, 'DisplayCurrency' => 'EGP'],
    ]);

    $this->myfatoorahMock->shouldReceive('getCurrency')->andReturn('USD');

    $response = $this->get(route('myfatoorah.callback', ['paymentId' => 'pay-1']));

    $response->assertRedirect(route('shop.checkout.cart.index'));

    expect(Order::query()->where('cart_id', $cart->id)->exists())->toBeFalse();
});
