<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'payment-title' => 'Title',
                        'description-title' => 'Description',
                        'logo' => 'Logo',
                        'description' => 'Myfatoorah Payment Module enable to make payment with multiple payment options like ApplePay, GooglePay, Credit and Debit cards.',
                        'api-key' => 'API Key',
                        'test-mode' => 'Test Mode',
                        'country-iso' => [
                            'title' => 'Country ISO',
                            'kwt' => 'Kuwait',
                            'sau' => 'Saudi Arabia',
                            'qat' => 'Qatar',
                            'bhr' => 'Bahrain',
                            'omn' => 'Oman',
                            'jod' => 'Jordan',
                            'egy' => 'Egypt',
                            'are' => 'United Arab Emirates',
                        ],
                        'is-webhook-enabled' => 'Enable Webhook',
                        'webhook-secret-key' => 'Webhook Secret Key',
                        'status' => 'Status',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah could not refund :amount: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Checkout',
            'error-title' => 'Payment Error',
            'back-to-cart' => 'Back to Cart',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Please configure your MyFatoorah API key first.',
        'cart-not-found' => 'Your cart could not be found.',
        'payment-failed' => 'The payment could not be completed. Please try again.',
        'payment-success' => 'Your payment was successful!',
    ],
];
