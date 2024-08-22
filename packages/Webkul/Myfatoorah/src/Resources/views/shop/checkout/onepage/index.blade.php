<!-- SEO Meta Content -->
@push('meta')
    <meta name="description" content="{{ __('shop::app.checkout.onepage.index.checkout') }}" />
    <meta name="keywords" content="{{ __('shop::app.checkout.onepage.index.checkout') }}" />
@endpush

    <x-shop::layouts
        :has-header="false"
        :has-feature="false"
        :has-footer="false"
    >
    @bagistoVite([ 'src/Resources/assets/css/style.css', 'src/Resources/assets/js/app.js', 'src/Resources/assets/js/checkout.js'], 'myfatoorah')
    <!-- Page Title -->
    <x-slot:title>
        {{ __('shop::app.checkout.onepage.index.checkout') }}
    </x-slot>

    {!! view_render_event('bagisto.shop.checkout.onepage.header.before') !!}

    <!-- Page Header -->
    <div class="flex-wrap">
        <div class="w-full flex justify-between px-[60px] py-4 border border-t-0 border-b border-l-0 border-r-0 max-lg:px-8 max-sm:px-4">
            <div class="flex items-center gap-x-14 max-[1180px]:gap-x-9">
                <a
                    href="{{ route('shop.home.index') }}"
                    class="flex min-h-[30px]"
                    aria-label="{{ __('shop::checkout.onepage.index.bagisto') }}"
                >
                    <img
                        src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                        alt="{{ config('app.name') }}"
                        width="131"
                        height="29"
                    >
                </a>
            </div>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.checkout.onepage.header.after') !!}

    <!-- Page Content -->
    <div class="container px-[60px] max-lg:px-8 max-sm:px-4">

        {!! view_render_event('bagisto.shop.checkout.onepage.breadcrumbs.before') !!}

        <!-- Breadcrumbs -->
        <x-shop::breadcrumbs name="checkout" />

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
            <template v-if="!cart">
                <!-- Shimmer Effect -->
                <x-shop::shimmer.checkout.onepage />
            </template>

            <template v-else>
                <div class="grid grid-cols-[1fr_auto] gap-8 max-lg:grid-cols-[1fr]">
                    <div
                        class="overflow-y-auto"
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
                            @include('vendor.shop.checkout.onepage.paynent')
                        </template>
                    </div>

                    <!-- Included Checkout Summary Blade File -->
                    <div class="sticky top-8 h-max w-[442px] max-w-full ltr:pl-8 rtl:pr-8 max-lg:w-auto max-lg:max-w-[442px] max-lg:ltr:pl-0 max-lg:rtl:pr-0">
                        @include('shop::checkout.onepage.summary')

                        <div
                            class="flex justify-end"
                            v-if="canPlaceOrder"
                        >
                            <template v-if="cart.payment_method == 'paypal_smart_button'">
                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.before') !!}

                                <v-paypal-smart-button></v-paypal-smart-button>

                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.after') !!}
                            </template>

                            <template v-else-if="childPaymentMethod == 'gp'">
                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.before') !!}

                                    <div id="gp-container" class="w-full"></div>

                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.after') !!}
                            </template>

                            <template v-else-if="childPaymentMethod == 'ap'">
                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.before') !!}

                                    <div id="ap-container" class="w-full"></div>

                                {!! view_render_event('bagisto.shop.checkout.onepage.summary.paypal_smart_button.after') !!}
                            </template>

                            <template v-else-if="childPaymentMethod == 'vm'">
                                    <x-shop::modal ref="paymentModal">
                                        <!-- Modal Toggler -->
                                        <x-slot:toggle>
                                            <x-shop::button 
                                                type="button"
                                                class="primary-button w-max py-3 px-11 bg-navyBlue rounded-2xl max-sm:text-sm max-sm:px-6 max-sm:mb-10"
                                                :title="trans('shop::app.checkout.onepage.summary.place-order')"
                                                ::disabled="isPlacingOrder"
                                                ::loading="isPlacingOrder" @click="openModal"
                                            />
                                        </x-slot:toggle>

                                        <!-- Modal Contentd -->
                                        <x-slot:content>
                                            <!-- Apply Coupon Form -->
                                            <div id="mf-form-element"></div>
                                            <div class="flex flex-wrap ">
                                                <x-shop::button class="mf-btn mf-pay-now-btn relative max-sm:max-w-full max-sm:flex-auto cursor-pointer center" @click="paymentSubmit" type="button"
                                                    :title="trans('my_fatoorah::app.shop.checkout.pay-now')"
                                                />
                                                
                                                <x-shop::button class="mf-btn mf-pay-cancel-btn relative max-sm:max-w-full max-sm:flex-auto cursor-pointer center" @click="closeModal"
                                                
                                                    :title="trans('my_fatoorah::app.shop.checkout.cancel')"
                                                />
                                                
                                            </div>
                                        </x-slot:content>
                                    </x-shop::modal>
                            </template>

                            <template v-else>
                                <x-shop::button
                                    type="button"
                                    class="primary-button w-max py-3 px-11 bg-navyBlue rounded-2xl max-sm:text-sm max-sm:px-6 max-sm:mb-10"
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
                        
                        childPaymentMethod:null,
                        
                        isCartLoading: true,
                        
                        isPlacingOrder: false,
                        
                        currentStep: 'address',
                        
                        shippingMethods: null,
                        
                        paymentMethods: null,
                        
                        canPlaceOrder: false,
                        
                        config: {
                            sessionId: '', 
                            amount: "10", 
                            currencyCode: "", 
                            countryCode: "",
                            cardViewId: "gp-container",
                            callback: this.payment,
                            style: { 
                                frameHeight: 51,
                                button: {
                                    height: "40px",
                                    width: "100%",
                                    text: "pay", // Accepted texts: ["book", "buy", "checkout", "donate", "order", "pay", "plain", "subscribe"]
                                    borderRadius: "8px",
                                    color: "default", // Accepted colors: ["black", "white", "default"]
                                    language: "en"
                                }
                            }
                        }

                    }
                },

                computed: {
                    localeDirection() {
                        return "{{ (core()->getCurrentLocale() == 'ar') ? 'rtl' : 'ltr' }}";
                    },
                    saveCardHeight() {
                        return window.saveCard ? 190 : 130;
                    },
                    translations() {
                        return {
                        holderName: "{{ trans('my_fatoorah::app.shop.components.form.holder-name') }}",
                        cardNumber: "{{ trans('my_fatoorah::app.shop.components.form.card-number') }}",
                        expiryDate: "{{ trans('my_fatoorah::app.shop.components.form.expiry-date') }}",
                        securityCode: "{{ trans('my_fatoorah::app.shop.components.form.security-code') }}",
                        labelHolderName: "{{ trans('my_fatoorah::app.shop.components.form.card-holder-name-label') }}",
                        labelCardNumber: "{{ trans('my_fatoorah::app.shop.components.form.card-numberLabel') }}",
                        labelExpiryDate: "{{ trans('my_fatoorah::app.shop.components.form.expiry-dateLabel') }}",
                        labelSecurityCode: "{{ trans('my_fatoorah::app.shop.components.form.security-codeLabel') }}",
                        saveCard: "{{ trans('my_fatoorah::app.shop.components.form.save-card') }}",
                        addCard: "{{ trans('my_fatoorah::app.shop.components.form.add-card') }}",
                        deleteAlertTitle: "{{ trans('my_fatoorah::app.shop.components.form.deleteAlert.title') }}",
                        deleteAlertMessage: "{{ trans('my_fatoorah::app.shop.components.form.deleteAlert.message') }}",
                        deleteAlertConfirm: "{{ trans('my_fatoorah::app.shop.components.form.deleteAlert.confirm') }}",
                        deleteAlertCancel: "{{ trans('my_fatoorah::app.shop.components.form.deleteAlert.cancel') }}",
                        };
                    },
                },

                mounted() {
                    this.getCart();
                },

                methods: {
                    getCart() {
                        this.$axios.get("{{ route('shop.checkout.onepage.summary') }}")
                            .then(response => {
                                this.cart = response.data.data;
                                
                                this.isCartLoading = false;
                                
                                this.scrollToCurrentStep();
                            })
                            .catch(error => {});
                    },

                    stepForward(step) {
                        this.currentStep = step;

                        if (step === 'review') {
                            this.canPlaceOrder = true;
                            return;
                        }

                        this.canPlaceOrder = false;

                        if (this.currentStep === 'shipping') {
                            this.shippingMethods = null;
                        } else if (this.currentStep === 'payment') {
                            this.paymentMethods = null;
                        }
                    },

                    stepProcessed(data) {
                        if (this.currentStep === 'shipping') {
                            this.shippingMethods = data;
                        } else if (this.currentStep === 'payment') {
                            this.paymentMethods = data;
                        }

                        this.getCart();
                    },

                    scrollToCurrentStep() {
                        let container = document.getElementById('steps-container');

                        if (!container) {
                            return;
                        }

                        container.scrollIntoView({
                            behavior: 'smooth',
                            
                            block: 'end'
                        });
                    },

                    placeOrder() {
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
                                this.isPlacingOrder = false;
                                
                                this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                            });
                    },

                    loadMyFatoorahScript() {
                        this.childPaymentMethod = window.selectedMethod ? window.selectedMethod.PaymentMethodCode : '';
                        
                        if (! ('ap', 'gp').includes(this.childPaymentMethod)) {
                            return;
                        }
                        
                        const script = document.createElement('script');
                        
                        let pathUrl = window.selectedMethod.PaymentMethodCode == 'gp' ? '/googlepay/v1/googlepay.js' : (window.selectedMethod.PaymentMethodCode == 'ap' ? '/applepay/v3/applepay.js' : '/cardview/v2/session.js');
                        
                        script.src = window.jsEnvironment + pathUrl;
                        
                        this.config.cardViewId = window.selectedMethod.PaymentMethodCode == 'gp' ? 'gp-container' : (window.selectedMethod.PaymentMethodCode == 'ap' ? 'ap-container' : 'mf-form-element');

                        this.config.sessionId = window.paymentSession.SessionId;

                        this.config.countryCode = window.paymentSession.CountryCode;

                        this.config.currencyCode = window.selectedMethod.CurrencyIso;

                        this.config.amount = this.cart.grand_total;

                        script.onload = window.selectedMethod.PaymentMethodCode == 'gp' ? this.initMyFatoorahGP : this.initMyFatoorahAP;
                        
                        document.head.appendChild(script);
                    },

                    initMyFatoorahGP() {
                        if (window.myFatoorahGP) {
                            
                            document.getElementById(this.config.cardViewId).innerHTML = '';

                            window.myFatoorahGP.init(this.config);
                        } else {
                            console.error("myFatoorahGP is not loaded.");
                        }
                    },

                    initmyFatoorahAP() {
                        if (window.myFatoorahAP) {
                            
                            document.getElementById(cardViewId).innerHTML = '';

                            window.myFatoorahAP.init(this.config);
                        } else {
                            console.error("myFatoorahAP is not loaded.");
                        }
                    },
                    payment(response) {
                        console.log("Payment response:", response);
                    },

                    getStyleConfig() {
                        const translations = this.translations;
                        return {
                        hideCardIcons: false,
                        direction: this.localeDirection,
                        cardHeight: this.saveCardHeight,
                        tokenHeight: 160,
                        input: {
                            color: "black",
                            fontSize: "13px",
                            fontFamily: "sans-serif",
                            inputHeight: "32px",
                            inputMargin: "0px",
                            borderColor: "c7c7c7",
                            borderWidth: "1px",
                            borderRadius: "8px",
                            boxShadow: "",
                            placeHolder: {
                            holderName: translations.holderName,
                            cardNumber: translations.cardNumber,
                            expiryDate: translations.expiryDate,
                            securityCode: translations.securityCode,
                            }
                        },
                        label: {
                            display: false,
                            color: "black",
                            fontSize: "13px",
                            fontWeight: "normal",
                            fontFamily: "sans-serif",
                            text: {
                            holderName: translations.labelHolderName,
                            cardNumber: translations.labelCardNumber,
                            expiryDate: translations.labelExpiryDate,
                            securityCode: translations.labelSecurityCode,
                            },
                        },
                        error: {
                            borderColor: "red",
                            borderRadius: "8px",
                            boxShadow: "0px",
                        },
                        text: {
                            saveCard: translations.saveCard,
                            addCard: translations.addCard,
                            deleteAlert: {
                            title: translations.deleteAlertTitle,
                            message: translations.deleteAlertMessage,
                            confirm: translations.deleteAlertConfirm,
                            cancel: translations.deleteAlertCancel,
                            }
                        }
                        };
                    },

                    openModal() {
                        this.isModalOpen = true;

                        // Load the payment form when the modal is opened
                        const script = document.createElement('script');
                        
                        script.src = window.jsEnvironment + "/cardview/v2/session.js";
                        
                        this.config.cardViewId = 'mf-form-element';
                        
                        this.config.sessionId = window.paymentSession.SessionId;
                        
                        this.config.countryCode = window.paymentSession.CountryCode;
                        
                        this.config.style = this.getStyleConfig();
                        
                        script.onload = this.initmyFatoorahForm;
                        
                        document.head.appendChild(script);
                    },
                    closeModal() {
                        if (confirm("Are you sure ?")) 
                            this.$axios.put('{{ route('myfatoorah.checkout.orders.cancel') }}').then(response => {
                                window.location.href = response.data.redirect_url;
                            });
                    },

                    paymentSubmit() {
                        window.myFatoorah.submit();
                        window.addEventListener("message", this.mfCallback);
                    },

                    initmyFatoorahForm() {
                        if (window.myFatoorah) {
                            let { countryCode, sessionId, cardViewId, style} = this.config;
                            
                            document.getElementById(cardViewId).innerHTML = '';
                            
                            window.myFatoorah.init({ countryCode, sessionId, cardViewId, style});
                        } else {
                            console.error("myFatoorahAP is not loaded.");
                        }
                    },

                    mfCallback(response) {
                        window.location.href = "{{ url('myfatoorah') }}?sessionId=" + JSON.parse(response.data).data.Data.SessionId;
                    }
                },
            });
        </script>
    @endPushOnce
</x-shop::layouts>
