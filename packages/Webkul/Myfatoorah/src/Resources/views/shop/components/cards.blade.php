
@foreach($paymentMethods['cards'] as $card)
@php($cardTitle = (core()->getCurrentLocale() == 'ar') ? $card->PaymentMethodAr : $card->PaymentMethodEn)
    <div class="mf-card-container mf-div-{{$card->PaymentMethodCode}}" onclick="makeCardPayment('{{$card->PaymentMethodId}}')">
        <div class="mf-row-container">
            <img class="mf-payment-logo" src="{{$card->ImageUrl}}" alt="{{$cardTitle}}">
            <span class="mf-payment-text mf-card-title">{{$cardTitle}}</span>
        </div>
        <span class="mf-payment-text">
            {{ $card->GatewayData['GatewayTotalAmount'] }} {{ $card->GatewayData['GatewayCurrency'] }}
        </span>
    </div>
@endforeach

<script>
    function makeCardPayment(paymentId) {
        window.location.href = "{{url('myfatoorah')}}?paymentMethodId=" + paymentId;
    }
</script>

