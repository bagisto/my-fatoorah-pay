{!! view_render_event('bagisto.shop.checkout.onepage.payment_methods.before') !!}

<v-payment-methods
    :methods="paymentMethods"
    @payment-method-selected="setSelectedPaymentMethod"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <x-shop::shimmer.checkout.onepage.payment-method />
</v-payment-methods>

{!! view_render_event('bagisto.shop.checkout.onepage.payment_methods.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-payment-methods-template"
    >
        <div class="mb-7 max-md:last:!mb-0">
            <template v-if="! methods">
                <!-- Payment Method shimmer Effect -->
                <x-shop::shimmer.checkout.onepage.payment-method />
            </template>

            <template v-else>
                {!! view_render_event('bagisto.shop.checkout.onepage.payment_method.accordion.before') !!}

                <!-- Accordion Blade Component -->
                <x-shop::accordion class="overflow-hidden !border-b-0 max-md:rounded-lg max-md:!border-none max-md:!bg-gray-100">
                    <!-- Accordion Blade Component Header -->
                    <x-slot:header class="px-0 py-4 max-md:p-3 max-md:text-sm max-md:font-medium max-sm:p-2">

                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-medium max-md:text-base">
                                @lang('shop::app.checkout.onepage.payment.payment-method')
                            </h2>
                        </div>
                    </x-slot>

                    <!-- Accordion Blade Component Content -->
                    <x-slot:content class="mt-8 !p-0 max-md:mt-0 max-md:rounded-t-none max-md:border max-md:border-t-0 max-md:!p-4">
                        <div class="flex flex-wrap gap-7 max-md:gap-4 max-sm:gap-2.5">
                            <div
                                class="relative cursor-pointer max-md:max-w-full max-md:flex-auto"
                                v-for="(payment, index) in methods"
                            >
                                {!! view_render_event('bagisto.shop.checkout.payment-method.before') !!}

                                <input
                                    type="radio"
                                    name="payment[method]"
                                    :value="payment.payment"
                                    :id="payment.method"
                                    class="peer hidden"
                                    @change="store(payment)"
                                >

                                <label
                                    :for="payment.method"
                                    class="icon-radio-unselect peer-checked:icon-radio-select absolute top-5 cursor-pointer text-2xl text-navyBlue ltr:right-5 rtl:left-5"
                                >
                                </label>

                                <label
                                    :for="payment.method"
                                    class="block w-[190px] cursor-pointer rounded-xl border border-zinc-200 p-5 max-md:flex max-md:w-full max-md:gap-5 max-md:rounded-lg max-md:ltr:pr-12 max-md:rtl:pl-12 max-sm:gap-4 max-sm:px-4 max-sm:py-2.5 max-sm:ltr:pr-12 max-sm:rtl:pl-12"
                                >
                                    {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.image.before') !!}

                                    <img
                                        class="max-h-11 max-w-14"
                                        :src="payment.image"
                                        width="55"
                                        height="55"
                                        :alt="payment.method_title"
                                        :title="payment.method_title"
                                    />

                                    {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.image.after') !!}

                                    <div>
                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.title.before') !!}

                                        <p class="mt-1.5 text-sm font-semibold max-md:mt-1 max-sm:mt-0">
                                            @{{ payment.method_title }}
                                        </p>

                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.title.after') !!}

                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.description.before') !!}

                                        <p class="mt-2.5 text-xs font-medium text-zinc-500 max-md:mt-1 max-sm:mt-0">
                                            @{{ payment.description }}
                                        </p>

                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.description.after') !!}

                                    </div>
                                </label>

                                {!! view_render_event('bagisto.shop.checkout.payment-method.after') !!}

                                <!-- Todo implement the additionalDetails -->
                                {{-- \Webkul\Payment\Payment::getAdditionalDetails($payment['method'] --}}
                            </div>

                            <div
                                class="relative cursor-pointer max-md:max-w-full max-md:flex-auto"
                                v-for="(payment, index) in (mfpayments ? myfatoorahPaymentMethods : [])"
                            >
                                {!! view_render_event('bagisto.shop.checkout.payment-method.before') !!}

                                <input
                                    type="radio"
                                    name="payment[method]"
                                    class="peer hidden"
                                    :id="'myfatoorah_' + payment.PaymentMethodCode"
                                    :data-myfatoorah-method="payment.PaymentMethodCode"
                                    @change="store(mfpayments, payment.PaymentMethodCode)"
                                >

                                <label
                                    :for="'myfatoorah_' + payment.PaymentMethodCode"
                                    class="icon-radio-unselect peer-checked:icon-radio-select absolute top-5 cursor-pointer text-2xl text-navyBlue ltr:right-5 rtl:left-5"
                                >
                                </label>

                                <label
                                    :for="'myfatoorah_' + payment.PaymentMethodCode"
                                    class="block w-[190px] cursor-pointer rounded-xl border border-zinc-200 p-5 max-md:flex max-md:w-full max-md:gap-5 max-md:rounded-lg max-md:ltr:pr-12 max-md:rtl:pl-12 max-sm:gap-4 max-sm:px-4 max-sm:py-2.5 max-sm:ltr:pr-12 max-sm:rtl:pl-12"
                                >
                                    {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.image.before') !!}

                                    <img
                                        class="max-h-11 max-w-14"
                                        :src="payment.ImageUrl"
                                        width="55"
                                        height="55"
                                        :alt="paymentTitle(payment)"
                                        :title="paymentTitle(payment)"
                                    />

                                    {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.image.after') !!}

                                    <div>
                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.title.before') !!}

                                        <p class="mt-1.5 text-sm font-semibold max-md:mt-1 max-sm:mt-0">
                                            @{{ mfpayments.method_title }}
                                        </p>

                                        <p class="mt-2.5 text-xs font-medium text-zinc-500 max-md:mt-1 max-sm:mt-0">
                                            @{{ paymentTitle(payment) }}
                                        </p>

                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.title.after') !!}

                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.description.before') !!}

                                        {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.description.after') !!}
                                    </div>
                                </label>

                                {!! view_render_event('bagisto.shop.checkout.payment-method.after') !!}
                            </div>
                        </div>
                    </x-slot>
                </x-shop::accordion>

                {!! view_render_event('bagisto.shop.checkout.onepage.payment_method.accordion.after') !!}
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-payment-methods', {
            template: '#v-payment-methods-template',

            props: {
                methods: {
                    type: Object,
                    required: true,
                    default: () => null,
                },
            },

            emits: ['payment-method-selected', 'processing', 'processed'],

            data() {
                return {
                    myfatoorahPaymentMethods: [],
                };
            },

            computed: {
                mfpayments() {
                    return Object.values(this.methods || {}).find(method => method.method == 'myfatoorah') || null;
                },
            },

            watch: {
                mfpayments: {
                    immediate: true,

                    handler(mfpayments, previous) {
                        if (mfpayments && ! previous) {
                            this.getMyfatoorahPaymentMethods();
                        }
                    },
                },
            },

            methods: {
                store(selectedMethod, myfatoorahPaymentMethod = null) {
                    this.$emit('payment-method-selected', selectedMethod.method);

                    this.$emit('processing', 'review');

                    window.selectedMethod = myfatoorahPaymentMethod
                        ? this.myfatoorahPaymentMethods.find(method => method.PaymentMethodCode == myfatoorahPaymentMethod)
                        : null;

                    this.$axios.post("{{ route('shop.checkout.onepage.payment_methods.store') }}", {
                            payment: selectedMethod
                        })
                        .then(response => {
                            this.$emit('processed', response.data.cart);

                            this.$parent.loadMyFatoorahScript?.();

                            // Used in mobile view.
                            if (window.innerWidth <= 768) {
                                window.scrollTo({
                                    top: document.body.scrollHeight,
                                    behavior: 'smooth'
                                });
                            }
                        })
                        .catch(error => {
                            this.$emit('processing', 'payment');

                            if (error.response.data.redirect_url) {
                                window.location.href = error.response.data.redirect_url;
                            }
                        });
                },

                paymentTitle(payment) {
                    return "{{ core()->getCurrentLocale()->code }}" == 'ar' ? payment.PaymentMethodAr : payment.PaymentMethodEn;
                },

                getMyfatoorahPaymentMethods() {
                    this.$axios.get("{{ route('myfatoorah.getMethods') }}")
                        .then(response => {
                            window.saveCard = response.data.saveCard;

                            window.paymentSession = response.data.paymentSession;

                            window.jsEnvironment = response.data.jsEnvironment;

                            const canUseApplePay = Boolean(window.ApplePaySession && window.ApplePaySession.canMakePayments && window.ApplePaySession.canMakePayments());

                            this.myfatoorahPaymentMethods = Object.values(response.data.paymentMethods)
                                .filter(payment => ['ap', 'gp', 'vm'].includes(payment.PaymentMethodCode))
                                .filter(payment => payment.PaymentMethodCode != 'ap' || canUseApplePay)
                                .filter((payment, index, payments) => payments.findIndex(item => item.PaymentMethodCode == payment.PaymentMethodCode) == index);
                        })
                        .catch(error => {});
                },
            },
        });
    </script>
@endPushOnce
