<script src="{{ $jsEnvironment }}/googlepay/v1/googlepay.js"></script>
<script>
    let mfGpConfig = {
        sessionId: "{{ $paymentSession->SessionId }}", // Here you add the "SessionId" you receive from the InitiateSession endpoint.
        countryCode: "{{ $paymentSession->CountryCode }}", // Here, add your country code.
        amount: "{{ $paymentMethods['gp']->GatewayData['GatewayTotalAmount'] }}", // Add the invoice amount.
        currencyCode: "{{ $paymentMethods['gp']->GatewayData['GatewayCurrency'] }}", // Here, add your currency code.
        cardViewId: "googlepay-card",
        isProduction: true,
        callback: mfCallback
    };

    myFatoorahGP.init(mfGpConfig);
</script>
