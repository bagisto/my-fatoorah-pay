<script src="{{ $jsEnvironment }}/cardview/v2/session.js"></script>
<script>
    var config = {
        countryCode: "{{ $mfSession->CountryCode }}",
        sessionId: "{{ $mfSession->SessionId }}",
        cardViewId: "mf-form-element",
        style: {
            hideCardIcons: false,
            direction: "{{App::isLocale('ar') ? 'rtl' : 'ltr'}}",
            cardHeight: {{ $userDefinedField ? 190 : 130 }},
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
                    holderName:   " {{ trans('my_fatoorah::app.checkout.holderName') }}",
                    cardNumber:   " {{ trans('my_fatoorah::app.checkout.cardNumber') }}",
                    expiryDate:   " {{ trans('my_fatoorah::app.checkout.expiryDate') }}",
                    securityCode: " {{ trans('my_fatoorah::app.checkout.securityCode') }}",
                }
            },
            label: {
                display: false,
                color: "black",
                fontSize: "13px",
                fontWeight: "normal",
                fontFamily: "sans-serif",
                text: {
                    holderName:   " {{ trans('my_fatoorah::app.checkout.cardHolderNameLabel') }}",
                    cardNumber:   " {{ trans('my_fatoorah::app.checkout.cardNumberLabel') }}",
                    expiryDate:   " {{ trans('my_fatoorah::app.checkout.expiryDateLabel') }}",
                    securityCode: " {{ trans('my_fatoorah::app.checkout.securityCodeLabel') }}",
                },
            },
            error: {
                borderColor: "red",
                borderRadius: "8px",
                boxShadow: "0px",
            },
            text: {
                saveCard: " {{ trans('my_fatoorah::app.checkout.saveCard') }}",
                addCard:  " {{ trans('my_fatoorah::app.checkout.addCard') }}",
                deleteAlert: {
                    tilte:   " {{ trans('my_fatoorah::app.checkout.deleteAlert.title') }}",
                    message: " {{ trans('my_fatoorah::app.checkout.deleteAlert.message') }}",
                    confirm: " {{ trans('my_fatoorah::app.checkout.deleteAlert.confirm') }}",
                    cancel:  " {{ trans('my_fatoorah::app.checkout.deleteAlert.cancel') }}"
                }
            }
        },
    };
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
