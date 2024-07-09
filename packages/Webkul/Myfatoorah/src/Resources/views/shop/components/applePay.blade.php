<script src="{{$jsEnvironment}}/applepay/v2/applepay.js"></script>
<script>
var mfApConfig = {
    sessionId: "{{ $mfSession->SessionId }}",
    countryCode: "{{ $mfSession->CountryCode }}",
    amount: "{{ $paymentMethods['ap']->GatewayData['GatewayTotalAmount'] }}",
    currencyCode: "{{ $paymentMethods['ap']->GatewayData['GatewayCurrency'] }}",
    cardViewId: "mf-ap-element",
    callback: mfCallback
};

myFatoorahAP.init(mfApConfig);
</script>