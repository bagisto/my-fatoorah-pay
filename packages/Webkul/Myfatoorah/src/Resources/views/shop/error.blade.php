<x-shop::layouts 
    :hasHeader=false
    :hasFooter=false
    :hasFeature=false
>
    <x-slot:title>
        @lang('my_fatoorah::app.shop.checkout.page-title')
    </x-slot>

    @bagistoVite([ 
        'src/Resources/assets/css/app.css', 
        'src/Resources/assets/css/style.css', 
        'src/Resources/assets/js/app.js',
    ], 'myfatoorah')

        <div class="mf-payment-methods-container">
            <div class="mf-danger-text">
                {{$errorMessage}}
            </div>
        </div>
</x-shop::layouts>