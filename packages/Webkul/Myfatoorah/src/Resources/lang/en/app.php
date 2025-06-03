<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Description',
                        'logo'               => 'Logo',
                        'description'        => 'Myfatoorah Payment Module enable to make payment with multiple payment options like ApplePay, GooglePay, Credit and Debit cards.',
                        'api-key'            => 'API Key',
                        'test-mode'          => 'Test Mode',
                        'country-iso'        => [
                            'title' => 'Country ISO',
                            'kwt'   => 'Kuwait',
                            'sau'   => 'Saudi Arabia',
                            'qat'   => 'Qatar',
                            'bhr'   => 'Bahrain',
                            'omn'   => 'Oman',
                            'jod'   => 'Jordan',
                            'egy'   => 'Egypt',
                            'are'   => 'United Arab Emirates',
                        ],
                        'is-webhook-enabled' => 'Enable Webhook',
                        'save-card'          => 'Save Card',
                        'webhook-secret-key' => 'Webhook Secret Key',
                        'register-apple-pay' => 'Register Apple Pay',
                        'status'             => 'Status',
                    ],
                ],
            ],
        ],
        
        'settings' => [
            'map-apple-pay' => [
                'title'       => 'Map Apple Pay',
                'description' => 'Map Apple Pay in MyFatoorah Settings',
                'save-btn'    => 'Save',
                'back-btn'    => 'Back',
                'url'         => 'URL',
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'                => 'MyFatoorah - Checkout',
            'no-payment-gateways'       => 'There are no payment methods available on your account, please contact your account manager.',
            'how-would-you-like-to-pay' => 'How would you like to pay?',
            'or'                        => 'Or',
            'pay-with'                  => 'Pay With',
            'insert-card-details'       => 'Insert Card Details',
            'pay-now'                   => 'Pay Now',
            'cancel'                    => 'Cancel',
            'invoice-success'           => 'Invoice is paid.',
            'invoice-failed'            => 'Invoice is not paid due to :error',
            'method-unavailable'        => 'This Payment Method is InActive please try another one',
            'invalid-webhook-data'      => 'Invalid Webhook Data',
            'no-webhook-signature'      => 'Webhook Signature is not available.',
            'no-webhook-secretKey'      => 'Webhook Secret Key is not available.',
            'invalid-webhook-signature' => 'Invalid Webhook Signature.',
            'error-occurred'            => 'Error Occurred While Processing Your Request.',
            'error-title'               => 'Payment Error',
            'back-to-cart'              => 'Back to Cart',
        ],

        'error' => [
            'page-title' => 'MyFatoorah Error',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'Name On Card',
                'card-number'            => 'Number',
                'expiry-date'            => 'MM/YY',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'Card Holder Name',
                'card-number-label'      => 'Card Number',
                'expiry-date-label'      => 'Expiry Date',
                'security-code-label'    => 'Security Code',
                'save-card'              => 'Save card number for future payments',
                'add-card'               => 'Use another card',
                'deleteAlert'            => [
                    'title'    => 'Delete Card',
                    'message'  => 'Are you sure you want to remove this card?',
                    'confirm'  => 'Yes',
                    'cancel'   => 'No',
                ],
            ],
        ],
    ],
];
