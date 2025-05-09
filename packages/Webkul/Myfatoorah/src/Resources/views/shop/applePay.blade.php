<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://demo.myfatoorah.com/applepay/v3/applepay.js"></script>
</head>
<body>
<div id="card-element"></div>

<script>

var config = {
    sessionId: "dca2a37e-8ec4-43e3-a93c-9ba1495b73bf", // Here you add the "SessionId" you receive from InitiateSession Endpoint.
    countryCode: "KWT", // Here, add your Country Code. 
    currencyCode: "KWD", // Here, add your Currency Code.
    amount: "10", // Add the invoice amount.
    cardViewId: "card-element",
    callback: payment,  
};

myFatoorahAP.init(config);

myFatoorahAP.updateAmount(config.amount);


function payment(response) {
    // Here you need to pass session id to you backend here 
    var sessionId = response.sessionId;
    var cardBrand = response.cardBrand;
  	var cardIdentifier = response.cardIdentifier;

    $.ajax({
        url:'https://apitest.myfatoorah.com/v2/ExecutePayment',
        method:"POST",
        data:{
            SessionId:SessionId,
            InvoiceValue:config.amount
        },
        success:function(success) {
            console.log(success);
        }
    })
}
</script>
</body>
</html>