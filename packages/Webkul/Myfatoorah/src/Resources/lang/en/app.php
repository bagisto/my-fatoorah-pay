<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description'        => 'Secure payment module with payment method support, card data storage, refund capabilities, and Webhook integration for real-time status updates',
                        'api-key'            => 'API Key',
                        'test-mode'          => 'Test Mode',
                        'currency-iso'       => [
                            'title' => 'Currency ISO',
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
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'MyFatoorah - Checkout',
            'noPaymentGateways'       => 'There are no payment methods available on your account, please contact your account manager.',
            'howWouldYouLikeToPay'    => 'How would you like to pay?',
            'or'                      => 'Or',
            'payWith'                 => 'Pay With',
            'insertCardDetails'       => 'Insert Card Details',
            'payNow'                  => 'Pay Now',
            'invoice-success'         => 'Invoice is paid.',
            'invoice-failed'          => 'Invoice is not paid due to :error',
            'method-unavailable'      => 'This Payment Method is InActive please try another one',
            'invalidWebhookData'      => 'Invalid Webhook Data',
            'noWebhookSignature'      => 'Webhook Signature is not available.',
            'noWebhookSecretKey'      => 'Webhook Secret Key is not available.',
            'invalidWebhookSignature' => 'Invalid Webhook Signature.',
        ],

        'error' => [
            'page-title' => 'MyFatoorah Error',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'Name On Card',
                'cardNumber'           => 'Number',
                'expiryDate'           => 'MM/YY',
                'securityCode'         => 'CVV',
                'cardHolderNameLabel'  => 'Card Holder Name',
                'cardNumberLabel'      => 'Card Number',
                'expiryDateLabel'      => 'Expiry Date',
                'securityCodeLabel'    => 'Security Code',
                'saveCard'             => 'Save card number for future payments',
                'addCard'              => 'Use another card',
                'deleteAlert'          => [
                    'title'    => 'Delete Card',
                    'message'  => 'Are you sure you want to remove this card?',
                    'confirm'  => 'Yes',
                    'cancel'   => 'No',
                ],
            ],
        ],
    ],
];
