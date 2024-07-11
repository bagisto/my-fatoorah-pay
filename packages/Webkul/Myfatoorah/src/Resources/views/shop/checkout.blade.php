<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>
            @lang('my_fatoorah::app.shop.checkout.pageCheckout')
        </title>
    </head>
        @bagistoVite([ 
            'src/Resources/assets/css/app.css', 
            'src/Resources/assets/css/style.css', 
            'src/Resources/assets/js/app.js',
            'src/Resources/assets/js/checkout.js',
        ], 'myfatoorah')
    <body dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr'}}">
        <div class="mf-payment-methods-container" id="mf-noPaymentGateways">
            <div class="mf-danger-text">
             @lang('my_fatoorah::app.shop.checkout.noPaymentGateways')
            </div>
        </div>
        <div class="mf-payment-methods-container" id="mf-paymentGateways" >
            <div class="mf-grey-text">
             @lang('my_fatoorah::app.shop.checkout.howWouldYouLikeToPay')
            </div>

            <!-- Google Pay & Apple Pay -->
            <div id="mf-sectionButtons">
                <!-- Apple Pay -->
                @if(! empty($paymentMethods['ap']))
                <div id="mf-sectionAP">
                    <div id="mf-ap-element" style="height: 40px;"></div>
                </div>
                @endif
                <!-- Google Pay -->
                @if(! empty($paymentMethods['gp']))
                <div id="mf-sectionGP">
                    <div id="googlepay-card"></div>
                </div>
                @endif
            </div>

            @if(! empty($paymentMethods['cards'] ))
            <div id="mf-sectionCard">
                <div class="mf-divider card-divider" id="mf-payWith-cardDivider">
                    <span class="mf-divider-span" id="mf-payWith-divider">
                        <span id="mf-or-cardsDivider">
                            {{ (! empty($paymentMethods['ap'] )) || (! empty($paymentMethods['gp'] )) ? trans('myfatoorah.or') : ''}}
                        </span>
                     @lang('my_fatoorah::app.shop.checkout.payWith')
                    </span>
                </div>
                <div id="mf-cards">
                    <x-myfatoorah::cards :paymentMethods="$paymentMethods"/>
                </div>
            </div>
            @endif

            <!-- Payment Form -->
            @if(! empty($paymentMethods['form']))
            <div class="mf-divider">
                <span class="mf-divider-span">
                    <span id="mf-or-formDivider">
                        {{! empty($paymentMethods['cards'] ) || ! empty($paymentMethods['ap'] ) || ! empty($paymentMethods['gp'] ) ? trans('my_fatoorah::app.shop.checkout.or') :''}}
                    </span>
                 @lang('my_fatoorah::app.shop.checkout.insertCardDetails')
                </span>
            </div>
            <div id="mf-form-element" style="width:99%; max-width:800px; padding: 0rem 0.2rem"></div>

            <button class="mf-btn mf-pay-now-btn" onclick="paymentSubmit()" type="button" style="
                    border: none; border-radius: 8px;
                    padding: 7px 3px; background-color: #0293cc">
                <span class="mf-pay-now-span">
                 @lang('my_fatoorah::app.shop.checkout.payNow')
                </span>
            </button>
            @endif
            
            <script>
                function mfCallback(response) {
                    window.location.href = "{{url('myfatoorah')}}?sessionId=" + response.sessionId;
                }
            </script>

            <!-- Google Pay Scripts -->
            @if(! empty($paymentMethods['gp']))
                <x-myfatoorah::googlePay 
                    :paymentMethods="$paymentMethods"
                    :jsEnvironment="$jsEnvironment"
                    :mfSession='$mfSession'
                />
            @endif

            <!-- Apple Pay Scripts -->
            @if(! empty($paymentMethods['ap']))
                <x-myfatoorah::applePay 
                    :paymentMethods="$paymentMethods"
                    :jsEnvironment="$jsEnvironment"
                    :mfSession='$mfSession' 
                />
            @endif

            <!-- Payment Form Scripts -->
            @if(! empty($paymentMethods['form']))
                <x-myfatoorah::form 
                    :paymentMethods="$paymentMethods"
                    :jsEnvironment="$jsEnvironment"
                    :mfSession='$mfSession' 
                    :userDefinedField="$userDefinedField"
                />
            @endif
        </div>
    </body>
</html>