<?php

use Webkul\Myfatoorah\Payment\Myfatoorah;

beforeEach(function () {
    $this->myfatoorah = app(Myfatoorah::class);
});

// ============================================================================
// Configuration
// ============================================================================

it('should return the correct payment method code', function () {
    expect($this->myfatoorah->getCode())->toBe('myfatoorah');
});

it('should return the payment method title from configuration', function () {
    $this->setConfig('sales.payment_methods.myfatoorah.title', 'MyFatoorah Payment Gateway');

    expect($this->myfatoorah->getTitle())->toBe('MyFatoorah Payment Gateway');
});

it('should return the payment method description from configuration', function () {
    $this->setConfig('sales.payment_methods.myfatoorah.description', 'Pay securely using MyFatoorah');

    expect($this->myfatoorah->getDescription())->toBe('Pay securely using MyFatoorah');
});

it('should return the configured logo url', function () {
    $this->setConfig('sales.payment_methods.myfatoorah.logo', 'myfatoorah/custom-logo.png');

    expect($this->myfatoorah->getImage())->toContain('myfatoorah/custom-logo.png');
});

// ============================================================================
// Credentials
// ============================================================================

it('has no valid credentials without an api key and a country', function () {
    $this->setConfig([
        'sales.payment_methods.myfatoorah.api_key' => '',
        'sales.payment_methods.myfatoorah.country_iso' => '',
    ]);

    expect($this->myfatoorah->hasValidCredentials())->toBeFalse();
});

it('has valid credentials once an api key and a country are set', function () {
    $this->setConfig([
        'sales.payment_methods.myfatoorah.api_key' => 'live-key',
        'sales.payment_methods.myfatoorah.country_iso' => 'KWT',
    ]);

    expect($this->myfatoorah->hasValidCredentials())->toBeTrue();
});

it('is not available without valid credentials even when active', function () {
    $this->setConfig([
        'sales.payment_methods.myfatoorah.active' => '1',
        'sales.payment_methods.myfatoorah.api_key' => '',
    ]);

    expect($this->myfatoorah->isAvailable())->toBeFalse();
});

// ============================================================================
// Base URL
// ============================================================================

it('resolves the sandbox base url regardless of country when test mode is enabled', function () {
    $this->setConfig([
        'sales.payment_methods.myfatoorah.test_mode' => '1',
        'sales.payment_methods.myfatoorah.country_iso' => 'SAU',
    ]);

    expect($this->myfatoorah->getBaseUrl())->toBe(Myfatoorah::SANDBOX_URL);
});

it('resolves the live base url per account country', function (string $country, string $url) {
    $this->setConfig([
        'sales.payment_methods.myfatoorah.test_mode' => '0',
        'sales.payment_methods.myfatoorah.country_iso' => $country,
    ]);

    expect($this->myfatoorah->getBaseUrl())->toBe($url);
})->with([
    ['KWT', 'https://api.myfatoorah.com'],
    ['BHR', 'https://api.myfatoorah.com'],
    ['JOD', 'https://api.myfatoorah.com'],
    ['OMN', 'https://api.myfatoorah.com'],
    ['ARE', 'https://api-ae.myfatoorah.com'],
    ['SAU', 'https://api-sa.myfatoorah.com'],
    ['QAT', 'https://api-qa.myfatoorah.com'],
    ['EGY', 'https://api-eg.myfatoorah.com'],
]);

// ============================================================================
// Currency
// ============================================================================

it('reports three decimal places for the currencies myfatoorah settles that way', function (string $currency, int $decimals) {
    expect($this->myfatoorah->getCurrencyDecimal($currency))->toBe($decimals);
})->with([
    ['KWD', 3],
    ['BHD', 3],
    ['OMR', 3],
    ['JOD', 3],
    ['USD', 2],
    ['SAR', 2],
    ['AED', 2],
    ['EGP', 2],
]);

it('reads the currency off the cart', function () {
    $cart = (object) ['cart_currency_code' => 'KWD'];

    expect($this->myfatoorah->getCurrency($cart))->toBe('KWD');
});
