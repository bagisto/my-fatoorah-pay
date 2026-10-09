<?php

use Webkul\Myfatoorah\Exceptions\RefundFailedException;
use Webkul\Myfatoorah\Listeners\Refund;
use Webkul\Myfatoorah\Payment\Myfatoorah;
use Webkul\Sales\Contracts\Refund as RefundContract;
use Webkul\Sales\Repositories\OrderTransactionRepository;

/**
 * A refund stub satisfying the empty `RefundContract` marker interface the listener type-hints,
 * carrying just the fields `afterCreated()` reads off it and its order.
 */
function myfatoorahRefundStub(int $id, object $order, float $grandTotal): RefundContract
{
    return new class($id, $order, $grandTotal) implements RefundContract
    {
        public function __construct(
            public int $id,
            public object $order,
            public float $grand_total,
        ) {}
    };
}

beforeEach(function () {
    $this->myfatoorahMock = $this->mock(Myfatoorah::class)->makePartial();

    $this->myfatoorahMock->shouldReceive('getCurrencyDecimal')->andReturn(2);

    $this->app->instance(Myfatoorah::class, $this->myfatoorahMock);
});

it('does nothing for an order paid with a different method', function () {
    $order = (object) ['payment' => (object) ['method' => 'cashondelivery']];

    app(Refund::class)->afterCreated(myfatoorahRefundStub(1, $order, 0.0));

    expect(true)->toBeTrue();
});

it('throws RefundFailedException when the order has no paid myfatoorah transaction', function () {
    $order = (object) [
        'id' => 1,
        'increment_id' => '100000001',
        'order_currency_code' => 'USD',
        'payment' => (object) ['method' => 'myfatoorah'],
    ];

    $repository = $this->mock(OrderTransactionRepository::class);

    $repository->shouldReceive('findWhere')->andReturn(collect());

    $this->app->instance(OrderTransactionRepository::class, $repository);

    app(Refund::class)->afterCreated(myfatoorahRefundStub(7, $order, 10.0));
})->throws(RefundFailedException::class);

it('throws RefundFailedException when myfatoorah refuses the refund', function () {
    $order = (object) [
        'id' => 1,
        'increment_id' => '100000001',
        'order_currency_code' => 'USD',
        'payment' => (object) ['method' => 'myfatoorah'],
    ];

    $transaction = (object) ['id' => 1, 'data' => json_encode(['Transaction' => ['PaymentId' => 'pay-1']])];

    $repository = $this->mock(OrderTransactionRepository::class);

    $repository->shouldReceive('findWhere')->andReturn(collect([$transaction]));

    $this->app->instance(OrderTransactionRepository::class, $repository);

    $this->myfatoorahMock->shouldReceive('createRefund')->with('pay-1', 10.0, '0')->andReturn(null);

    app(Refund::class)->afterCreated(myfatoorahRefundStub(0, $order, 10.0));
})->throws(RefundFailedException::class);

it('does not throw when myfatoorah accepts the refund', function () {
    $order = (object) [
        'id' => 1,
        'increment_id' => '100000001',
        'order_currency_code' => 'USD',
        'payment' => (object) ['method' => 'myfatoorah'],
    ];

    $transaction = (object) ['id' => 1, 'data' => json_encode(['Transaction' => ['PaymentId' => 'pay-1']])];

    $repository = $this->mock(OrderTransactionRepository::class);

    $repository->shouldReceive('findWhere')->andReturn(collect([$transaction]));

    $this->app->instance(OrderTransactionRepository::class, $repository);

    $this->myfatoorahMock->shouldReceive('createRefund')->with('pay-1', 10.0, '9')->andReturn(['Refund' => ['Status' => 'Pending']]);

    app(Refund::class)->afterCreated(myfatoorahRefundStub(9, $order, 10.0));

    expect(true)->toBeTrue();
});
