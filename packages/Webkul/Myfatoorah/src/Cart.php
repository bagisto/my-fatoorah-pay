<?php

namespace Webkul\Myfatoorah;

use Webkul\Product\Repositories\ProductRepository;
use Webkul\Tax\Repositories\TaxCategoryRepository;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\Checkout\Traits\CartTools;
use Webkul\Checkout\Models\CartPayment;
use Webkul\Checkout\Traits\CartCoupons;
use Webkul\Checkout\Traits\CartValidators;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Checkout\Repositories\CartItemRepository;
use Webkul\Checkout\Repositories\CartAddressRepository;
use Webkul\Checkout\Cart as BaseCart;

class Cart extends BaseCart
{
    use CartCoupons, CartTools, CartValidators;

    /**
     * @var \Webkul\Checkout\Contracts\Cart
     */
    private $cart;

    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct(
        protected CartRepository $cartRepository,
        protected CartItemRepository $cartItemRepository,
        protected CartAddressRepository $cartAddressRepository,
        protected ProductRepository $productRepository,
        protected TaxCategoryRepository $taxCategoryRepository,
        protected WishlistRepository $wishlistRepository,
        protected CustomerAddressRepository $customerAddressRepository
    ) {
        $this->initCart();
        $this->cart = parent::getCart();
    }

    /**
     * Returns cart.
     *
     * @return \Webkul\Checkout\Contracts\Cart|null
     */
    public function initCart()
    {
        $this->getCart();
    }

    /**
     * Returns cart.
     */
    public function getCart(): ?\Webkul\Checkout\Contracts\Cart
    {
        if ($this->cart) {
            return $this->cart;
        }

        if (auth()->guard()->check()) {
            $this->cart = $this->cartRepository->findOneWhere([
                'customer_id' => auth()->guard()->user()->id,
                'is_active'   => 1,
            ]);
        } elseif (session()->has('cart')) {
            $this->cart = $this->cartRepository->find(session()->get('cart')->id);
        }

        return $this->cart;
    }

    /**
     * Save payment method for cart.
     *
     * @param  string  $payment
     * @return \Webkul\Checkout\Contracts\CartPayment
     */
    public function savePaymentMethod($payment)
    {
        $cart = $this->getCart();

        if (! $cart) {
            return false;
        }

        if ($cartPayment = $cart->payment) {
            $cartPayment->delete();
        }

        $cartPayment = new CartPayment;

        $cartPayment->method = $payment['method'];
        $cartPayment->method_title = core()->getConfigData('sales.payment_methods.'.$payment['method'].'.title');
        $cartPayment->cart_id = $cart->id;
        $cartPayment->childMethod = $payment['childMethod'] ?? null;
        $cartPayment->save();

        return $cartPayment;
    }

}
