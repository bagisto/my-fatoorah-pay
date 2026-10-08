<?php

namespace Webkul\Myfatoorah\Listeners;

use Exception;
use Illuminate\Support\Facades\Log;
use MyFatoorah\Library\API\MyFatoorahRefund;
use Webkul\Myfatoorah\Exceptions\RefundFailedException;
use Webkul\Sales\Contracts\Refund as RefundContract;
use Webkul\Sales\Repositories\OrderTransactionRepository;

class Refund
{
    /**
     * Currencies MyFatoorah settles with three decimals.
     *
     * @var array
     */
    const THREE_DECIMAL_CURRENCIES = ['KWD', 'BHD', 'OMR', 'JOD'];

    /**
     * Create a new listener instance.
     *
     * @return void
     */
    public function __construct(protected OrderTransactionRepository $orderTransactionRepository) {}

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
            'order_id'       => $order->id,
            'payment_method' => 'myfatoorah',
            'status'         => 'Paid',
        ])->sortByDesc('id')->first();

        $invoiceId = json_decode((string) $transaction?->data)?->InvoiceId ?? null;

        $decimals = in_array($order->order_currency_code, self::THREE_DECIMAL_CURRENCIES) ? 3 : 2;

        $amount = round((float) $refund->grand_total, $decimals);

        try {
            if (! $invoiceId) {
                throw new Exception('The order has no paid MyFatoorah invoice.');
            }

            app(MyFatoorahRefund::class)->makeRefund([
                'Key'                     => $invoiceId,
                'KeyType'                 => 'InvoiceId',
                'RefundChargeOnCustomer'  => false,
                'ServiceChargeOnCustomer' => false,
                'Amount'                  => $amount,
                'CurrencyIso'             => $order->order_currency_code,
            ]);
        } catch (Exception $exception) {
            Log::error('MyFatoorah: the refund could not be made.', [
                'order'   => $order->increment_id,
                'message' => $exception->getMessage(),
            ]);

            throw new RefundFailedException(trans('my_fatoorah::app.admin.refund-failed', [
                'amount'  => core()->formatPrice($amount, $order->order_currency_code),
                'message' => $exception->getMessage(),
            ]));
        }
    }
}
