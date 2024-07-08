<script src="{{$jsEnvironment}}/cardview/v2/session.js"></script>
<script>
    var config = {
        countryCode: "{{$mfSession->CountryCode}}", // Here, add your Country Code.
        sessionId: "{{$mfSession->SessionId}}", // Here you add the "SessionId" you receive from InitiateSession Endpoint.
        cardViewId: "mf-form-element",
        cartId: "{{Cart::getCart()->id}}",
        // The following style is optional.
        style: {
            hideCardIcons: false,
            direction: "{{App::isLocale('ar') ? 'rtl' : 'ltr'}}",
            cardHeight: {{$userDefinedField ? 190 : 130}},
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
                    holderName:   " @lang('my_fatoorah::app.checkout.holderName')",
                    cardNumber:   " @lang('my_fatoorah::app.checkout.cardNumber')",
                    expiryDate:   " @lang('my_fatoorah::app.checkout.expiryDate')",
                    securityCode: " @lang('my_fatoorah::app.checkout.securityCode')",
                }
            },
            label: {
                display: false,
                color: "black",
                fontSize: "13px",
                fontWeight: "normal",
                fontFamily: "sans-serif",
                text: {
                    holderName:   " @lang('my_fatoorah::app.checkout.cardHolderNameLabel')",
                    cardNumber:   " @lang('my_fatoorah::app.checkout.cardNumberLabel')",
                    expiryDate:   " @lang('my_fatoorah::app.checkout.expiryDateLabel')",
                    securityCode: " @lang('my_fatoorah::app.checkout.securityCodeLabel')",
                },
            },
            error: {
                borderColor: "red",
                borderRadius: "8px",
                boxShadow: "0px",
            },
            text: {
                saveCard: " @lang('my_fatoorah::app.checkout.saveCard')",
                addCard:  " @lang('my_fatoorah::app.checkout.addCard')",
                deleteAlert: {
                    tilte:   " @lang('my_fatoorah::app.checkout.deleteAlert.title')",
                    message: " @lang('my_fatoorah::app.checkout.deleteAlert.message')",
                    confirm: " @lang('my_fatoorah::app.checkout.deleteAlert.confirm')",
                    cancel:  " @lang('my_fatoorah::app.checkout.deleteAlert.cancel')"
                }
            }
        },
    };
    console.log(config);
    myFatoorah.init(config);

    function submit() {
        myFatoorah.submit()
            // On success
            .then(function (response) {
                mfCallback(response);
            })
            // In case of errors
            .catch(function (error) {
                alert(error);
            });
    }
</script>
