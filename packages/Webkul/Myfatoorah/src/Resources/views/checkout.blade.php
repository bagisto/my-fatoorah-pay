<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
    <head>
        <title>@lang('myfatoorah.pageCheckout')</title>
        <link rel="stylesheet" href="{{asset('vendor/myfatoorah/css/style.css')}}"/>
    </head>
    <body dir="{{App::isLocale('ar') ? 'rtl' : 'ltr'}}">
        <div class="mf-payment-methods-container" id="mf-noPaymentGateways">
            <div class="mf-danger-text">
             @lang('my_fatoorah::app.checkout.noPaymentGateways')
            </div>
        </div>
        <div class="mf-payment-methods-container" id="mf-paymentGateways" >
            <div class="mf-grey-text">
             @lang('my_fatoorah::app.checkout.howWouldYouLikeToPay')
            </div>

            <!-- Google Pay & Apple Pay -->
            <div id="mf-sectionButtons">
                <!-- Apple Pay -->
                @if(!empty($paymentMethods['ap']))
                <div id="mf-sectionAP">
                    <div id="mf-ap-element" style="height: 40px;"></div>
                </div>
                @endif
                <!-- Google Pay -->
                @if(!empty($paymentMethods['gp']))
                <div id="mf-sectionGP">
                    <div id="mf-gp-element"></div>
                </div>
                @endif
            </div>

            @if(!empty($paymentMethods['cards'] ))
            <div id="mf-sectionCard">
                <div class="mf-divider card-divider" id="mf-payWith-cardDivider">
                    <span class="mf-divider-span" id="mf-payWith-divider">
                        <span id="mf-or-cardsDivider">
                            {{!empty($paymentMethods['ap'] ) || !empty($paymentMethods['gp'] ) ? __('myfatoorah.or') : ''}}
                        </span>
                     @lang('my_fatoorah::app.checkout.payWith')
                    </span>
                </div>
                <div id="mf-cards">
                    @include('myfatoorah::includes.sectionCards')
                </div>
            </div>
            @endif

            <!-- Payment Form -->
            @if(!empty($paymentMethods['form']))
            <div class="mf-divider">
                <span class="mf-divider-span">
                    <span id="mf-or-formDivider">
                        {{!empty($paymentMethods['cards'] ) || !empty($paymentMethods['ap'] ) || !empty($paymentMethods['gp'] ) ? __('myfatoorah.or') :''}}
                    </span>
                 @lang('my_fatoorah::app.checkout.insertCardDetails')
                </span>
            </div>
            <div id="mf-form-element" style="width:99%; max-width:800px; padding: 0rem 0.2rem"></div>

            <button class="mf-btn mf-pay-now-btn" onclick="submit()" type="button" style="
                    border: none; border-radius: 8px;
                    padding: 7px 3px; background-color: #0293cc">
                <span class="mf-pay-now-span">
                 @lang('my_fatoorah::app.checkout.payNow')
                </span>
            </button>
            @endif

            <script src="{{asset('vendor/myfatoorah/js/checkout.js')}}"></script>
            <script>
                function mfCallback(response) {
                    window.location.href = "{{url('myfatoorah')}}?sid=" + response.sessionId;
                }
            </script>

            <!-- Google Pay Scripts -->
            @if(!empty($paymentMethods['gp']))
            @include('myfatoorah::includes.sectionGooglePay')
            @endif

            <!-- Apple Pay Scripts -->
            @if(!empty($paymentMethods['ap']))
            @include('myfatoorah::includes.sectionApplePay')
            @endif

            <!-- Payment Form Scripts -->
            @if(!empty($paymentMethods['form']))
            @include('myfatoorah::includes.sectionForm')
            @endif
        </div>
    </body>
</html>