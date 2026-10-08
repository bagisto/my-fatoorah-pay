<?php

namespace Webkul\Myfatoorah\Listeners;

use Exception;
use Illuminate\Support\Facades\Log;
use Webkul\Myfatoorah\Exceptions\RefundFailedException;
use Webkul\Myfatoorah\Payment\Myfatoorah;
use Webkul\Sales\Contracts\Refund as RefundContract;
use Webkul\Sales\Repositories\OrderTransactionRepository;

class Refund
{
    /**
     * Create a new listener instance.
     *
     * @return void
     */
    public function __construct(
        protected Myfatoorah $myfatoorah,
        protected OrderTransactionRepository $orderTransactionRepository,
    ) {}

    /**
     * Refund a refund created for a MyFatoorah order through MyFatoorah. It runs inside the refund's
     * database transaction, so a failure stops the refund from being saved.
     *
     * @throws RefundFailedException
     */
    public function afterCreated(RefundContract $refund): void
    {
        $order = $refund->order;

        if ($order->payment?->method != 'myfatoorah') {
            return;
        }

        $transaction = $this->orderTransactionRepository->findWhere([
            'order_id' => $order->id,
            'payment_method' => 'myfatoorah',
        ])->sortByDesc('id')->first();

        $paymentId = json_decode((string) $transaction?->data, true)['Transaction']['PaymentId'] ?? null;

        $decimal = $this->myfatoorah->getCurrencyDecimal($order->order_currency_code);

        $amount = round((float) $refund->grand_total, $decimal);

        try {
            if (! $paymentId) {
                throw new Exception('The order has no paid MyFatoorah payment.');
            }

            if (! $this->myfatoorah->createRefund($paymentId, $amount, (string) $refund->id)) {
                throw new Exception('MyFatoorah refused the refund.');
            }
        } catch (Exception $exception) {
            Log::error('MyFatoorah: the refund could not be made.', [
                'order' => $order->increment_id,
                'message' => $exception->getMessage(),
            ]);

            throw new RefundFailedException(trans('my_fatoorah::app.admin.refund-failed', [
                'amount' => core()->formatPrice($amount, $order->order_currency_code),
                'message' => $exception->getMessage(),
            ]));
        }
    }
}
