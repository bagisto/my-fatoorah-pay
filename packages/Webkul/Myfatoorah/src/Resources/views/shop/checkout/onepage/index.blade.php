<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="@lang('shop::app.checkout.onepage.index.checkout')"/>

    <meta name="keywords" content="@lang('shop::app.checkout.onepage.index.checkout')"/>
@endPush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    @bagistoVite(['src/Resources/assets/css/style.css', 'src/Resources/assets/js/app.js', 'src/Resources/assets/js/checkout.js'], 'myfatoorah')

    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.checkout.onepage.index.checkout')
    </x-slot>

    {!! view_render_event('bagisto.shop.checkout.onepage.header.before') !!}

    <!-- Page Header -->
    <div class="flex-wrap">
        <div class="flex w-full justify-between border border-b border-l-0 border-r-0 border-t-0 px-[60px] py-4 max-lg:px-8 max-sm:px-4">
            <div class="flex items-center gap-x-14 max-[1180px]:gap-x-9">
                <a
                    href="{{ route('shop.home.index') }}"
                    class="flex min-h-[30px]"
                    aria-label="@lang('shop::checkout.onepage.index.bagisto')"
                >
                    <img
                        src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                        alt="{{ core()->getCurrentChannel()->logo_alt ?: config('app.name') }}"
                        width="131"
                        height="29"
                    >
                </a>
            </div>

            @guest('customer')
                @include('shop::checkout.login')
            @endguest
        </div>
    </div>

    {!! view_render_event('bagisto.shop.checkout.onepage.header.after') !!}

    <!-- Page Content -->
    <div class="container px-[60px] max-lg:px-8 max-sm:px-4">

        {!! view_render_event('bagisto.shop.checkout.onepage.breadcrumbs.before') !!}

        <!-- Breadcrumbs -->
        @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
            <x-shop::breadcrumbs name="checkout" />
        @endif

        {!! view_render_event('bagisto.shop.checkout.onepage.breadcrumbs.after') !!}

        <!-- Checkout Vue Component -->
        <v-checkout>
            <!-- Shimmer Effect -->
            <x-shop::shimmer.checkout.onepage />
        </v-checkout>
    </div>

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-checkout-template"
        >
            <template v-if="! cart">
                <!-- Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage />
            </template>

            <template v-else>
                <div class="grid grid-cols-[1fr_auto] gap-8 max-lg:grid-cols-[1fr] max-md:gap-5">
                    <!-- Included Checkout Summary Blade File For Mobile view -->
                    <div class="hidden max-md:block">
                        @include('shop::checkout.onepage.summary')
                    </div>

                    <div
                        class="overflow-y-auto max-md:grid max-md:gap-4"
                        id="steps-container"
                    >
                        <!-- Included Addresses Blade File -->
                        <template v-if="['address', 'shipping', 'payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.address')
                        </template>

                        <!-- Included Shipping Methods Blade File -->
                        <template v-if="cart.have_stockable_items && ['shipping', 'payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.shipping')
                        </template>

                        <!-- Included Payment Methods Blade File -->
                        <template v-if="['payment', 'review'].includes(currentStep)">
                            @include('shop::checkout.onepage.payment')
                        </template>
                    </div>

                    <!-- Included Checkout Summary Blade File For Desktop view -->
                    <div class="sticky top-8 block h-max w-[442px] max-w-full max-lg:w-auto max-lg:max-w-[442px] ltr:pl-8 max-lg:ltr:pl-0 rtl:pr-8 max-lg:rtl:pr-0">
                        <div class="block max-md:hidden">
                            @include('shop::checkout.onepage.summary')
                        </div>

                        <div
                            class="flex justify-end"
                            v-if="canPlaceOrder"
                        >
                            <template v-if="(selectedPaymentMethod || cart.payment_method) == 'paypal_smart_button'">
                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.before') !!}

                                <!-- Paypal Smart Button Vue Component -->
                                <v-paypal-smart-button></v-paypal-smart-button>

                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.after') !!}
                            </template>

                            <template v-else-if="isMyFatoorahMethod('gp')">
                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.before') !!}

                                <div
                                    id="gp-container"
                                    class="w-full"
                                ></div>

                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.after') !!}
                            </template>

                            <template v-else-if="isMyFatoorahMethod('ap')">
                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.before') !!}

                                <div
                                    id="ap-container"
                                    class="w-full"
                                ></div>

                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.after') !!}
                            </template>

                            <template v-else-if="isMyFatoorahMethod('vm')">
                                <x-shop::modal ref="paymentModal">
                                    <!-- Modal Toggler -->
                                    <x-slot:toggle>
                                        <x-shop::button
                                            type="button"
                                            class="primary-button w-max rounded-2xl bg-navyBlue px-11 py-3 max-md:mb-4 max-md:w-full max-md:max-w-full max-md:rounded-lg max-sm:py-1.5"
                                            :title="trans('shop::app.checkout.onepage.summary.place-order')"
                                            ::disabled="isPlacingOrder"
                                            ::loading="isPlacingOrder"
                                            @click="openModal"
                                        />
                                    </x-slot>

                                    <!-- Modal Header -->
                                    <x-slot:header>
                                        <h2 class="text-xl font-medium max-sm:text-base">
                                            @lang('my_fatoorah::app.shop.checkout.insert-card-details')
                                        </h2>
                                    </x-slot>

                                    <!-- Modal Content -->
                                    <x-slot:content>
                                        <div id="mf-form-element"></div>

                                        <div class="mt-4 flex flex-wrap gap-4">
                                            <x-shop::button
                                                type="button"
                                                class="primary-button rounded-2xl bg-navyBlue px-11 py-3 max-md:w-full max-md:rounded-lg max-sm:py-1.5"
                                                :title="trans('my_fatoorah::app.shop.checkout.pay-now')"
                                                ::disabled="isPlacingOrder"
                                                ::loading="isPlacingOrder"
                                                @click="paymentSubmit"
                                            />

                                            <x-shop::button
                                                type="button"
                                                class="secondary-button rounded-2xl px-11 py-3 max-md:w-full max-md:rounded-lg max-sm:py-1.5"
                                                :title="trans('my_fatoorah::app.shop.checkout.cancel')"
                                                ::disabled="isPlacingOrder"
                                                @click="closeModal"
                                            />
                                        </div>
                                    </x-slot>
                                </x-shop::modal>
                            </template>

                            <template v-else>
                                <x-shop::button
                                    type="button"
                                    class="primary-button w-max rounded-2xl bg-navyBlue px-11 py-3 max-md:mb-4 max-md:w-full max-md:max-w-full max-md:rounded-lg max-sm:py-1.5"
                                    :title="trans('shop::app.checkout.onepage.summary.place-order')"
                                    ::disabled="isPlacingOrder"
                                    ::loading="isPlacingOrder"
                                    @click="placeOrder"
                                />
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </script>

        <script type="module">
            app.component('v-checkout', {
                template: '#v-checkout-template',

                data() {
                    return {
                        cart: null,

                        displayTax: {
                            prices: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_prices') }}",

                            subtotal: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_subtotal') }}",

                            shipping: "{{ core()->getConfigData('sales.taxes.shopping_cart.display_shipping_amount') }}",
                        },

                        isPlacingOrder: false,

                        currentStep: 'address',

                        shippingMethods: null,

                        paymentMethods: null,

                        selectedPaymentMethod: null,

                        canPlaceOrder: false,

                        childPaymentMethod: null,

                        isRedirectingToMyFatoorah: false,

                        config: {
                            sessionId: '',
                            amount: '',
                            currencyCode: '',
                            countryCode: '',
                            cardViewId: 'gp-container',
                            callback: null,
                            style: {
                                frameHeight: 51,
                                button: {
                                    height: '40px',
                                    width: '100%',
                                    text: 'pay',
                                    borderRadius: '8px',
                                    color: 'default',
                                    language: "{{ core()->getCurrentLocale()->code == 'ar' ? 'ar' : 'en' }}",
                                },
                            },
                        },
                    }
                },

                computed: {
                    localeDirection() {
                        return "{{ core()->getCurrentLocale()->direction == 'rtl' ? 'rtl' : 'ltr' }}";
                    },

                    saveCardHeight() {
                        return window.saveCard ? 190 : 130;
                    },

                    translations() {
                        return {{ \Illuminate\Support\Js::from([
                            'holderName'         => trans('my_fatoorah::app.shop.components.form.holder-name'),
                            'cardNumber'         => trans('my_fatoorah::app.shop.components.form.card-number'),
                            'expiryDate'         => trans('my_fatoorah::app.shop.components.form.expiry-date'),
                            'securityCode'       => trans('my_fatoorah::app.shop.components.form.security-code'),
                            'labelHolderName'    => trans('my_fatoorah::app.shop.components.form.card-holder-name-label'),
                            'labelCardNumber'    => trans('my_fatoorah::app.shop.components.form.card-number-label'),
                            'labelExpiryDate'    => trans('my_fatoorah::app.shop.components.form.expiry-date-label'),
                            'labelSecurityCode'  => trans('my_fatoorah::app.shop.components.form.security-code-label'),
                            'saveCard'           => trans('my_fatoorah::app.shop.components.form.save-card'),
                            'addCard'            => trans('my_fatoorah::app.shop.components.form.add-card'),
                            'deleteAlertTitle'   => trans('my_fatoorah::app.shop.components.form.deleteAlert.title'),
                            'deleteAlertMessage' => trans('my_fatoorah::app.shop.components.form.deleteAlert.message'),
                            'deleteAlertConfirm' => trans('my_fatoorah::app.shop.components.form.deleteAlert.confirm'),
                            'deleteAlertCancel'  => trans('my_fatoorah::app.shop.components.form.deleteAlert.cancel'),
                        ]) }};
                    },
                },

                watch: {
                    'cart.grand_total'(amount) {
                        if (this.childPaymentMethod == 'ap' && window.myFatoorahAP?.updateAmount) {
                            window.myFatoorahAP.updateAmount(amount);
                        }

                        if (this.childPaymentMethod == 'gp' && window.myFatoorahGP?.updateAmount) {
                            window.myFatoorahGP.updateAmount(amount);
                        }
                    },
                },

                mounted() {
                    this.getCart();

                    window.addEventListener('pageshow', (event) => {
                        if (event.persisted) {
                            this.isRedirectingToMyFatoorah = false;

                            this.isPlacingOrder = false;
                        }
                    });
                },

                methods: {
                    getCart() {
                        this.$axios.get("{{ route('shop.checkout.onepage.summary') }}")
                            .then(response => {
                                this.cart = response.data.data;

                                this.scrollToCurrentStep();
                            })
                            .catch(error => {});
                    },

                    stepForward(step) {
                        this.currentStep = step;

                        if (step == 'review') {
                            this.canPlaceOrder = true;

                            return;
                        }

                        this.canPlaceOrder = false;

                        if (this.currentStep == 'shipping') {
                            this.shippingMethods = null;
                        } else if (this.currentStep == 'payment') {
                            this.paymentMethods = null;
                        }
                    },

                    stepProcessed(data) {
                        if (this.currentStep == 'shipping') {
                            this.shippingMethods = data;
                        } else if (this.currentStep == 'payment') {
                            this.paymentMethods = data;
                        }

                        this.getCart();
                    },

                    scrollToCurrentStep() {
                        let container = document.getElementById('steps-container');

                        if (! container) {
                            return;
                        }

                        container.scrollIntoView({
                            behavior: 'smooth',
                            block: 'end'
                        });
                    },

                    setSelectedPaymentMethod(method) {
                        this.selectedPaymentMethod = method;
                    },

                    placeOrder() {
                        if ((this.selectedPaymentMethod || this.cart.payment_method) == 'paypal_smart_button') {
                            return;
                        }

                        this.isPlacingOrder = true;

                        this.$axios.post('{{ route('shop.checkout.onepage.orders.store') }}')
                            .then(response => {
                                if (response.data.data.redirect) {
                                    window.location.href = response.data.data.redirect_url;
                                } else {
                                    window.location.href = '{{ route('shop.checkout.onepage.success') }}';
                                }

                                this.isPlacingOrder = false;
                            })
                            .catch(error => {
                                this.isPlacingOrder = false

                                this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                            });
                    },

                    isMyFatoorahMethod(code) {
                        return (this.selectedPaymentMethod || this.cart.payment_method) == 'myfatoorah'
                            && this.childPaymentMethod == code;
                    },

                    loadMyFatoorahScript() {
                        this.childPaymentMethod = window.selectedMethod ? window.selectedMethod.PaymentMethodCode : '';

                        if (! ['ap', 'gp'].includes(this.childPaymentMethod)) {
                            return;
                        }

                        const script = document.createElement('script');

                        script.src = window.jsEnvironment + (this.childPaymentMethod == 'gp' ? '/googlepay/v1/googlepay.js' : '/applepay/v3/applepay.js');

                        this.config.cardViewId = this.childPaymentMethod == 'gp' ? 'gp-container' : 'ap-container';

                        this.config.sessionId = window.paymentSession.SessionId;

                        this.config.countryCode = window.paymentSession.CountryCode;

                        this.config.currencyCode = window.selectedMethod.CurrencyIso;

                        this.config.amount = this.cart.grand_total;

                        this.config.callback = this.mfCallback;

                        script.onload = this.childPaymentMethod == 'gp' ? this.initMyFatoorahGP : this.initMyFatoorahAP;

                        script.onerror = this.showPaymentError;

                        document.head.appendChild(script);
                    },

                    initMyFatoorahGP() {
                        if (! window.myFatoorahGP) {
                            this.showPaymentError();

                            return;
                        }

                        this.$nextTick(() => {
                            const container = document.getElementById(this.config.cardViewId);

                            if (! container) {
                                return;
                            }

                            container.innerHTML = '';

                            window.myFatoorahGP.init(this.config);
                        });
                    },

                    initMyFatoorahAP() {
                        if (! window.myFatoorahAP) {
                            this.showPaymentError();

                            return;
                        }

                        this.$nextTick(() => {
                            const container = document.getElementById(this.config.cardViewId);

                            if (! container) {
                                return;
                            }

                            container.innerHTML = '';

                            let { sessionId, countryCode, amount, currencyCode, cardViewId, callback } = this.config;

                            window.myFatoorahAP.init({ sessionId, countryCode, amount, currencyCode, cardViewId, callback });
                        });
                    },

                    getStyleConfig() {
                        const translations = this.translations;

                        return {
                            hideCardIcons: false,
                            direction: this.localeDirection,
                            cardHeight: this.saveCardHeight,
                            tokenHeight: 160,
                            input: {
                                color: 'black',
                                fontSize: '13px',
                                fontFamily: 'sans-serif',
                                inputHeight: '32px',
                                inputMargin: '0px',
                                borderColor: 'c7c7c7',
                                borderWidth: '1px',
                                borderRadius: '8px',
                                boxShadow: '',
                                placeHolder: {
                                    holderName: translations.holderName,
                                    cardNumber: translations.cardNumber,
                                    expiryDate: translations.expiryDate,
                                    securityCode: translations.securityCode,
                                },
                            },
                            label: {
                                display: false,
                                color: 'black',
                                fontSize: '13px',
                                fontWeight: 'normal',
                                fontFamily: 'sans-serif',
                                text: {
                                    holderName: translations.labelHolderName,
                                    cardNumber: translations.labelCardNumber,
                                    expiryDate: translations.labelExpiryDate,
                                    securityCode: translations.labelSecurityCode,
                                },
                            },
                            error: {
                                borderColor: 'red',
                                borderRadius: '8px',
                                boxShadow: '0px',
                            },
                            text: {
                                saveCard: translations.saveCard,
                                addCard: translations.addCard,
                                deleteAlert: {
                                    title: translations.deleteAlertTitle,
                                    message: translations.deleteAlertMessage,
                                    confirm: translations.deleteAlertConfirm,
                                    cancel: translations.deleteAlertCancel,
                                },
                            },
                        };
                    },

                    openModal() {
                        if (window.myFatoorah) {
                            this.initmyFatoorahForm();

                            return;
                        }

                        const script = document.createElement('script');

                        script.src = window.jsEnvironment + '/cardview/v2/session.js';

                        script.onload = this.initmyFatoorahForm;

                        script.onerror = this.showPaymentError;

                        document.head.appendChild(script);
                    },

                    closeModal() {
                        this.$refs.paymentModal.close();
                    },

                    paymentSubmit() {
                        this.isPlacingOrder = true;

                        const submission = window.myFatoorah.submit();

                        if (submission && typeof submission.then == 'function') {
                            submission
                                .then(this.mfCallback)
                                .catch(error => this.showPaymentError(error));

                            return;
                        }

                        window.addEventListener('message', this.mfMessage);
                    },

                    initmyFatoorahForm() {
                        this.config.cardViewId = 'mf-form-element';

                        this.config.sessionId = window.paymentSession.SessionId;

                        this.config.countryCode = window.paymentSession.CountryCode;

                        this.config.style = this.getStyleConfig();

                        this.$nextTick(() => {
                            let { countryCode, sessionId, cardViewId, style } = this.config;

                            const container = document.getElementById(cardViewId);

                            if (! container) {
                                return;
                            }

                            container.innerHTML = '';

                            window.myFatoorah.init({ countryCode, sessionId, cardViewId, style });
                        });
                    },

                    mfMessage(event) {
                        if (event.origin != new URL(window.jsEnvironment).origin) {
                            return;
                        }

                        try {
                            const sessionId = JSON.parse(event.data).data.Data.SessionId;

                            window.removeEventListener('message', this.mfMessage);

                            this.mfCallback({ sessionId });
                        } catch (error) {}
                    },

                    mfCallback(response) {
                        if (this.isRedirectingToMyFatoorah) {
                            return;
                        }

                        if (! response?.sessionId) {
                            this.showPaymentError();

                            return;
                        }

                        this.isRedirectingToMyFatoorah = true;

                        this.isPlacingOrder = true;

                        window.location.href = "{{ url('myfatoorah') }}?sessionId=" + encodeURIComponent(response.sessionId);
                    },

                    showPaymentError(error) {
                        this.isPlacingOrder = false;

                        this.$emitter.emit('add-flash', {
                            type: 'error',
                            message: error?.message || @json(trans('my_fatoorah::app.shop.checkout.error-occurred')),
                        });
                    },
                },
            });
        </script>
    @endPushOnce
</x-shop::layouts>
