<?php

return [
    /**
     * API Token Key (string)
     * Accepted value:
     * 
     */
    'api_key' => core()->getConfigData('sales.payment_methods.myfatoorah.api_key'),
    /**
     * Test Mode (boolean)
     * Accepted value: true for the test mode or false for the live mode
     */
    'test_mode' => core()->getConfigData('sales.payment_methods.myfatoorah.test_mode'),
    /**
     * Country ISO Code (string)
     * Accepted value: KWT, SAU, ARE, QAT, BHR, OMN, JOD, or EGY.
     */
    'country_iso' => core()->getConfigData('sales.payment_methods.myfatoorah.country_iso'),
    /**
     * Save card (boolean)
     * Accepted value: true if you want to enable save card options.
     * You should contact your account manager to enable this feature in your MyFatoorah account as well.
     */
    'save_card' => core()->getConfigData('sales.payment_methods.myfatoorah.save_card'),
    /**
     * Webhook secret key (string)
     * Enable webhook on your MyFatoorah account setting then paste the secret key here.
     * The webhook link is: https://{example.com}/myfatoorah/webhook
     */
    'webhook_secret_key' => core()->getConfigData('sales.payment_methods.myfatoorah.webhook_secret_key'),
    /**
     * Register Apple Pay (boolean)
     * Set it to true to show the Apple Pay on the checkout page.
     * First, verify your domain with Apple Pay before you set it to true.
     *
    */
    'register_apple_pay' => core()->getConfigData('sales.payment_methods.myfatoorah.register_apple_pay'),
];
