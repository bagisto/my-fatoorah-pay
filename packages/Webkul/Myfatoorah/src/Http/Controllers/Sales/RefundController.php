<?php

namespace Webkul\Myfatoorah\Http\Controllers\Sales;

use Webkul\Admin\DataGrids\Sales\OrderRefundDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Sales\Repositories\OrderItemRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\RefundRepository;
use Webkul\Sales\Repositories\OrderTransactionRepository;
use Webkul\Admin\Http\Controllers\Sales\RefundController as BaseRefundController;
use Webkul\Myfatoorah\Http\Controllers\MyFatoorahController;

class RefundController extends BaseRefundController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected OrderItemRepository $orderItemRepository,
        protected RefundRepository $refundRepository,
        protected OrderTransactionRepository $orderTransactionRepository,
        protected MyFatoorahController $myFatoorahController
    ) {
    }



    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(int $orderId)
    {
        $order = $this->orderRepository->findOrFail($orderId);
        
        $orderTransection = $this->orderTransactionRepository->where('order_id',$orderId)->latest()->first();
        
        

        if (! $order->canRefund()) {
            session()->flash('error', trans('admin::app.sales.refunds.create.creation-error'));

            return redirect()->back();
        }

        $this->validate(request(), [
            'refund.items'   => 'required|array',
            'refund.items.*' => 'required|numeric|min:0',
        ]);

        $data = request()->all();

        if (! isset($data['refund']['shipping'])) {
            $data['refund']['shipping'] = 0;
        }

        $totals = $this->refundRepository->getOrderItemsRefundSummary($data['refund']['items'], $orderId);

        if (! $totals) {
            session()->flash('error', trans('admin::app.sales.refunds.create.invalid-qty'));

            return redirect()->route('admin.sales.refunds.index');
        }

        $maxRefundAmount = $totals['grand_total']['price'] - $order->refunds()->sum('base_adjustment_refund');

        $refundAmount = $totals['grand_total']['price'] - $totals['shipping']['price'] + $data['refund']['shipping'] + $data['refund']['adjustment_refund'] - $data['refund']['adjustment_fee'];

        if (! $refundAmount) {
            session()->flash('error', trans('admin::app.sales.refunds.create.invalid-refund-amount-error'));

            return redirect()->back();
        }

        if ($refundAmount > $maxRefundAmount) {
            session()->flash('error', trans('admin::app.sales.refunds.create.refund-limit-error', [
                'amount' => core()->formatBasePrice($maxRefundAmount),
            ]));

            return redirect()->back();
        }

        $this->refundRepository->create(array_merge($data, ['order_id' => $orderId]));

        $orderTransection = $this->orderTransactionRepository->where('order_id',$orderId)->latest()->first();

        $this->myFatoorahController->refund($orderTransection);
        
        session()->flash('success', trans('admin::app.sales.refunds.create.create-success'));

        return redirect()->route('admin.sales.refunds.index');
    }


}
