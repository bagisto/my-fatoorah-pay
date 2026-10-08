<?php

namespace Webkul\Myfatoorah\Payment;

use Illuminate\Support\Facades\Storage;
use MyFatoorah\Library\MyFatoorah as MyFatoorahLibrary;
use Webkul\Checkout\Facades\Cart;
use Webkul\Payment\Payment\Payment;

class Myfatoorah extends Payment
{
    /**
     * Payment method code.
     *
     * @var string
     */
    protected $code = 'myfatoorah';

    /**
     * Return myfatoorah redirect url.
     */
    public function getRedirectUrl()
    {
        if ((bool) core()->getConfigData('sales.payment_methods.myfatoorah.status')) {

            return route('myfatoorah.checkout');
        }

        throw new \Exception(trans('my_fatoorah::app.shop.checkout.method-unavailable'));
    }

    /**
     * Get payment method image.
     *
     * @return string
     */
    public function getImage()
    {
        $url = $this->getConfigData('logo');

        return $url ? Storage::url($url) : @bagisto_asset('images/myfatoorah.png', 'myfatoorah');
    }

    /**
     * Checks if payment method is available.
     *
     * @return bool
     */
    public function isAvailable()
    {
        return core()->getConfigData('sales.payment_methods.myfatoorah.status')
            && $this->getConfigData('api_key')
            && (Cart::getCart() ? in_array(Cart::getCart()->cart_currency_code, ['KWD', 'SAR', 'BHD', 'AED', 'QAR', 'OMR', 'JOD', 'EGP', 'USD']) : true);
    }

    /**
     * Get the configuration array the MyFatoorah library is constructed with.
     */
    public function getLibraryConfig(): array
    {
        return [
            'apiKey'      => (string) $this->getConfigData('api_key'),
            'isTest'      => (bool) $this->getConfigData('test_mode'),
            'countryCode' => $this->getCountryCode(),
        ];
    }

    /**
     * Get the MyFatoorah account country, mapping the "JOD" value saved by earlier versions to the
     * "JOR" code the MyFatoorah library expects for Jordan.
     */
    public function getCountryCode(): string
    {
        $countryCode = strtoupper((string) $this->getConfigData('country_iso'));

        return $countryCode === 'JOD' ? 'JOR' : $countryCode;
    }

    /**
     * Get the MyFatoorah portal the embedded payment scripts are loaded from.
     */
    public function getJsEnvironment(): string
    {
        $country = MyFatoorahLibrary::getMFCountries()[$this->getCountryCode()] ?? [];

        return (string) ($this->getConfigData('test_mode') ? ($country['testPortal'] ?? '') : ($country['portal'] ?? ''));
    }
}
