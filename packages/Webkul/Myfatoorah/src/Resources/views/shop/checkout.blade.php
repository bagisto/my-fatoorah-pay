<!DOCTYPE html>
<html lang="{{ core()->getCurrentLocale()->code }}">

<head>
    <title>
        @lang('my_fatoorah::app.shop.checkout.page-title')
    </title>

    @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/css/style.css', 'src/Resources/assets/js/app.js', 'src/Resources/assets/js/checkout.js'], 'myfatoorah')

</head>

<body dir="{{ core()->getCurrentLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="mf-payment-methods-container" id="mf-noPaymentGateways">
        <div class="mf-danger-text">
            @lang('my_fatoorah::app.shop.checkout.no-payment-gateways')
        </div>
    </div>
    <div class="mf-payment-methods-container" id="mf-paymentGateways">
        <div class="mf-grey-text">
            @lang('my_fatoorah::app.shop.checkout.how-would-you-like-to-pay')
        </div>

        <!-- Apple Pay -->
        <div id="mf-sectionButtons">
            @if(!empty($paymentMethods['ap']))
            <div id="mf-sectionAP">
                <div id="mf-ap-element" style="height: 40px;"></div>
            </div>
            @endif
        </div>

        @if (!empty($paymentMethods['cards']))
            <div id="mf-sectionCard">
                <div class="mf-divider card-divider" id="mf-payWith-cardDivider">
                    <span class="mf-divider-span" id="mf-payWith-divider">
                        <span id="mf-or-cardsDivider">
                            {{ !empty($paymentMethods['ap']) || !empty($paymentMethods['gp']) ? trans('myfatoorah.or') : '' }}
                        </span>
                        @lang('my_fatoorah::app.shop.checkout.pay-with')
                    </span>
                </div>
                <div id="mf-cards">
                    <x-myfatoorah::cards :paymentMethods="$paymentMethods" />
                </div>
            </div>
        @endif

        @if(!empty($paymentMethods['ap']))
            <x-myfatoorah::applePay 
                :paymentMethods="$paymentMethods"
                :jsDomain="$jsEnvironment"
                :mfSession="$paymentSession" />
        @endif
        <!-- Payment Form -->
        @pushOnce('scripts')
            <script>
                function mfCallback(response) {
                    window.location.href = "{{ url('myfatoorah') }}?sessionId=" + response.sessionId;
                }
            </script>
        @endpushOnce
        
    </div>
</body>

</html>
