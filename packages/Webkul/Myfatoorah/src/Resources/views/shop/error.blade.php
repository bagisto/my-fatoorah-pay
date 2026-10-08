<x-shop::layouts>
    <x-slot:title>
        @lang('my_fatoorah::app.shop.checkout.page-title')
    </x-slot>

    @bagistoVite([ 
        'src/Resources/assets/css/app.css', 
        'src/Resources/assets/css/style.css', 
        'src/Resources/assets/js/app.js',
    ], 'myfatoorah')

    <div class="container mt-8 px-[60px] max-lg:px-8 max-sm:px-4">
        <div class="grid gap-y-5 place-items-center">
            {!! view_render_event('myfatoorah.shop.checkout.error.content.before') !!}

            <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <p class="text-center text-2xl font-medium text-[#DC2626]">
                @lang('my_fatoorah::app.shop.checkout.error-title')
            </p>

            <p class="text-center text-xl text-[#6E6E6E] max-sm:text-base">
                {{$errorMessage}}
            </p>

            {!! view_render_event('myfatoorah.shop.checkout.error.buttons.before') !!}

            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('shop.checkout.cart.index') }}">
                    <div class="block w-max mx-auto py-3 px-11 max-sm:px-6 bg-navyBlue rounded-2xl text-white text-base font-medium text-center cursor-pointer">
                        @lang('my_fatoorah::app.shop.checkout.back-to-cart')
                    </div>
                </a>

                <a href="{{ route('shop.home.index') }}">
                    <div class="block w-max mx-auto py-3 px-11 max-sm:px-6 bg-navyBlue rounded-2xl text-white text-base font-medium text-center cursor-pointer">
                        @lang('shop::app.checkout.cart.index.continue-shopping')
                    </div>
                </a>
            </div>

            {!! view_render_event('myfatoorah.shop.checkout.error.buttons.after') !!}
        </div>
    </div>
</x-shop::layouts>