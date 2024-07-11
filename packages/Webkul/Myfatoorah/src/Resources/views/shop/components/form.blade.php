<script src="{{ $jsEnvironment }}/cardview/v2/session.js"></script>
<script>
    var config = {
        countryCode: "{{ $mfSession->CountryCode }}",
        sessionId: "{{ $mfSession->SessionId }}",
        cardViewId: "mf-form-element",
        style: {
            hideCardIcons: false,
            direction: "{{ app()->isLocale('ar') ? 'rtl' : 'ltr'}}",
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
                    holderName:   " {{ trans('my_fatoorah::app.shop.components.form.holderName') }}",
                    cardNumber:   " {{ trans('my_fatoorah::app.shop.components.form.cardNumber') }}",
                    expiryDate:   " {{ trans('my_fatoorah::app.shop.components.form.expiryDate') }}",
                    securityCode: " {{ trans('my_fatoorah::app.shop.components.form.securityCode') }}",
                }
            },
            label: {
                display: false,
                color: "black",
                fontSize: "13px",
                fontWeight: "normal",
                fontFamily: "sans-serif",
                text: {
                    holderName:   " {{ trans('my_fatoorah::app.shop.components.form.cardHolderNameLabel') }}",
                    cardNumber:   " {{ trans('my_fatoorah::app.shop.components.form.cardNumberLabel') }}",
                    expiryDate:   " {{ trans('my_fatoorah::app.shop.components.form.expiryDateLabel') }}",
                    securityCode: " {{ trans('my_fatoorah::app.shop.components.form.securityCodeLabel') }}",
                },
            },
            error: {
                borderColor: "red",
                borderRadius: "8px",
                boxShadow: "0px",
            },
            text: {
                saveCard: " {{ trans('my_fatoorah::app.shop.components.form.saveCard') }}",
                addCard:  " {{ trans('my_fatoorah::app.shop.components.form.addCard') }}",
                deleteAlert: {
                    tilte:   " {{ trans('my_fatoorah::app.shop.components.form.deleteAlert.title') }}",
                    message: " {{ trans('my_fatoorah::app.shop.components.form.deleteAlert.message') }}",
                    confirm: " {{ trans('my_fatoorah::app.shop.components.form.deleteAlert.confirm') }}",
                    cancel:  " {{ trans('my_fatoorah::app.shop.components.form.deleteAlert.cancel') }}"
                }
            }
        },
    };
    myFatoorah.init(config);

    function paymentSubmit() {
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
