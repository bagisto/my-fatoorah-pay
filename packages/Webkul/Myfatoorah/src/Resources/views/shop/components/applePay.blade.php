<script src="{{$jsEnvironment}}/applepay/v2/applepay.js"></script>
<script>
    let mfApConfig = {
        sessionId: "{{ $paymentSession->SessionId }}",
        countryCode: "{{ $paymentSession->CountryCode }}",
        amount: "{{ $paymentMethods['ap']->GatewayData['GatewayTotalAmount'] }}",
        currencyCode: "{{ $paymentMethods['ap']->GatewayData['GatewayCurrency'] }}",
        cardViewId: "mf-ap-element",
        callback: mfCallback
    };

    myFatoorahAP.init(mfApConfig);
</script>