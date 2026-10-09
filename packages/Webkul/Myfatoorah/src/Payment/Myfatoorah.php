<?php

namespace Webkul\Myfatoorah\Payment;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
     * MyFatoorah's sandbox host, shared by every account country.
     */
    const SANDBOX_URL = 'https://apitest.myfatoorah.com';

    /**
     * MyFatoorah's live hosts, keyed by the account's country.
     *
     * @var array<string, string>
     */
    const PRODUCTION_URLS = [
        'KWT' => 'https://api.myfatoorah.com',
        'BHR' => 'https://api.myfatoorah.com',
        'JOD' => 'https://api.myfatoorah.com',
        'OMN' => 'https://api.myfatoorah.com',
        'ARE' => 'https://api-ae.myfatoorah.com',
        'SAU' => 'https://api-sa.myfatoorah.com',
        'QAT' => 'https://api-qa.myfatoorah.com',
        'EGY' => 'https://api-eg.myfatoorah.com',
    ];

    /**
     * Currencies MyFatoorah settles with three decimals.
     *
     * @var array
     */
    const THREE_DECIMAL_CURRENCIES = ['KWD', 'BHD', 'OMR', 'JOD'];

    /**
     * Get redirect URL for MyFatoorah payment.
     */
    public function getRedirectUrl()
    {
        return route('myfatoorah.redirect');
    }

    /**
     * Check if payment method is available.
     */
    public function isAvailable()
    {
        return parent::isAvailable() && $this->hasValidCredentials();
    }

    /**
     * Get payment method image.
     */
    public function getImage()
    {
        $url = $this->getConfigData('logo');

        return $url ? Storage::url($url) : Storage::url('myfatoorah/myfatoorah.png');
    }

    /**
     * Check if required credentials are configured.
     */
    public function hasValidCredentials(): bool
    {
        return ! empty($this->getConfigData('api_key'))
            && ! empty($this->getConfigData('country_iso'));
    }

    /**
     * Get the MyFatoorah host for the configured environment and account country.
     */
    public function getBaseUrl(): string
    {
        if ($this->getConfigData('test_mode')) {
            return self::SANDBOX_URL;
        }

        $country = strtoupper((string) $this->getConfigData('country_iso'));

        return self::PRODUCTION_URLS[$country] ?? self::PRODUCTION_URLS['KWT'];
    }

    /**
     * Get the currency the payment is charged in.
     */
    public function getCurrency($cart): string
    {
        return strtoupper($cart->cart_currency_code ?: core()->getCurrentCurrencyCode());
    }

    /**
     * Get the number of decimals a currency is charged with.
     */
    public function getCurrencyDecimal(string $currencyCode): int
    {
        return in_array(strtoupper($currencyCode), self::THREE_DECIMAL_CURRENCIES) ? 3 : 2;
    }

    /**
     * Create a Hosted Payment Page payment and return its `Data` object, or null on failure.
     *
     * Never sends `PaymentMethod` or `DisplayPaymentMethods` — omitting both is what makes
     * MyFatoorah's hosted page show every method the account has enabled (cards including Visa,
     * Mastercard, Mada and AMEX, Apple Pay, Google Pay, KNET, etc.) instead of restricting the
     * customer to one.
     */
    public function createPayment($cart, string $redirectionUrl, ?string $webhookUrl): ?array
    {
        $currency = $this->getCurrency($cart);

        $address = $cart->billing_address;

        $response = $this->request('POST', '/v3/payments', array_filter([
            'Order' => [
                'Amount' => round((float) $cart->grand_total, $this->getCurrencyDecimal($currency)),
                'Currency' => $currency,
                'ExternalIdentifier' => (string) $cart->id,
            ],
            'Customer' => array_filter([
                'Name' => trim(($cart->customer_first_name ?? '').' '.($cart->customer_last_name ?? '')) ?: null,
                'Email' => $cart->customer_email,
                'Reference' => (string) $cart->id,
                'Mobile' => $address?->phone ? [
                    'CountryCode' => '',
                    'Number' => preg_replace('/\D/', '', (string) $address->phone),
                ] : null,
            ]),
            'IntegrationUrls' => array_filter([
                'Redirection' => $redirectionUrl,
                'Webhook' => $webhookUrl,
            ]),
            'Language' => core()->getCurrentLocale()->code == 'ar' ? 'AR' : 'EN',
        ]));

        if (empty($response['Data']['PaymentURL'])) {
            return null;
        }

        return $response['Data'];
    }

    /**
     * Fetch the authoritative status of a payment from MyFatoorah.
     */
    public function getPaymentDetails(string $paymentId): ?array
    {
        $response = $this->request('GET', '/v3/payments/'.$paymentId, []);

        return $response['Data'] ?? null;
    }

    /**
     * Refund part or all of a paid payment.
     */
    public function createRefund(string $paymentId, float $amount, string $externalIdentifier): ?array
    {
        $response = $this->request('POST', '/v3/refunds', [
            'PaymentId' => $paymentId,
            'Amount' => $amount,
            'ExternalIdentifier' => $externalIdentifier,
            'ServiceChargeOnCustomer' => false,
        ]);

        return $response['Data'] ?? null;
    }

    /**
     * Send an authenticated request to MyFatoorah, returning the decoded body or null on failure.
     */
    protected function request(string $method, string $path, array $payload): ?array
    {
        try {
            $response = Http::withToken((string) $this->getConfigData('api_key'))
                ->acceptJson()
                ->send($method, $this->getBaseUrl().$path, $method === 'GET' ? [] : ['json' => $payload]);

            $body = $this->decode($response);

            if (! $body) {
                Log::warning('MyFatoorah: '.$method.' '.$path.' did not succeed.', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);
            }

            return $body;
        } catch (\Exception $e) {
            report($e);

            return null;
        }
    }

    /**
     * Decode a MyFatoorah response, returning null when it reports failure.
     */
    protected function decode(Response $response): ?array
    {
        $body = $response->json();

        if (
            ! is_array($body)
            || empty($body['IsSuccess'])
        ) {
            return null;
        }

        return $body;
    }
}
