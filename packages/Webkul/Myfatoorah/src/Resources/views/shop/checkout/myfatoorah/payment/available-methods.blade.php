
@if (
    request()->routeIs('shop.checkout.onepage.index')
)
    @php
        $clientId = core()->getConfigData('sales.payment_methods.paypal_smart_button.client_id');

        $acceptedCurrency = core()->getConfigData('sales.payment_methods.paypal_smart_button.accepted_currencies');
    @endphp
        <style>
            <link rel="stylesheet" href="{{asset('vendor/myfatoorah/css/style.css')}}"/>
        </style>
    <v-myfatoorah-available-methods>

    </v-myfatoorah-available-methods>
    @pushOnce('scripts')
        <script type="text/x-template" id="v-myfatoorah-available-methods-template">
            <template v-for="paymentMethod in paymentMethods" class="relative max-sm:max-w-full max-sm:flex-auto cursor-pointer">
                <div class="mf-card-container mf-div-en " v-on:click="mfCardSubmit(paymentMethod.PaymentMethodId)" >
                    <div class="mf-row-container ">
    
                                <label 
                                   
                                    class="absolute ltr:right-5 rtl:left-5 top-5 icon-radio-unselect text-2xl text-navyBlue peer-checked:icon-radio-select cursor-pointer"
                                >
                                    @{{paymentMethod.PaymentMethodEn}}
                                </label>

                                <label 
                                    :for="paymentMethod.method" 
                                    class="w-[190px] p-5 block border border-[#E9E9E9] rounded-xl max-sm:w-full cursor-pointer"
                                >
                                    {!! view_render_event('bagisto.shop.checkout.onepage.payment-method.image.before') !!}

                                    <img
                                        class="max-w-[55px] max-h-[45px]"
                                        :src="paymentMethod.ImageUrl"
                                        width="55"
                                        height="55"
                                        :alt="paymentMethod.method_title"
                                        :title="paymentMethod.method_title"
                                    />
                                    <p class="text-sm font-semibold mt-1.5">
                                        @{{paymentMethod.PaymentMethodEn}}
                                    </p>

                            </label>
                    </div>
                    
                </div>
            </template>
        </script>

        <script type="module">
            app.component('v-myfatoorah-available-methods', {
                template: '#v-myfatoorah-available-methods-template',

                data() {
                    return {
                        paymentMethods: [],
                        sessionId: "",
                    }
                },

                mounted() {
                    console.log(this.getPaymentMethod());
                },

                methods: {
                    getPaymentMethod() {
                        this.$axios.get("{{ route('shop.checkout.onepage.myfatoorah.getpament.methods') }}", {
                            
                        }).then(response => {
                            this.paymentMethods = response.data.paymentMethods.all;
                            this.sessionId = response.data.mfSession.SessionId;
                            console.log(response.data);
                            console.log(this.sessionId);
                        });
                    },

                    mfCardSubmit(pmid){
                        window.location.href = "{{url('myfatoorah')}}?pmid=" + pmid + "&sid=" + this.sessionId ;
                    }

                },
            });
        </script>
    @endPushOnce
@endif
