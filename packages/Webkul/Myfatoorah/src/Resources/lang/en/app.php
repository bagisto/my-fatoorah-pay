<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'        => 'MyFatoorah',
                        'description'  => 'Secure payment module with payment method support, card data storage, refund capabilities, and Webhook integration for real-time status updates',
                        'api-key'      => 'API Key',
                        'test-mode'    => 'Test Mode',
                        'currency-iso' => [
                            'title' => 'Currency ISO',
                            'kwt'   => 'Kuwaiti Dinar',
                            'sau'   => 'Saudi Riyal',
                            'qat'   => 'Qatari Riyal',
                            'bhr'   => 'Bahraini Rinar',
                            'omn'   => 'Omani Rial',
                            'jod'   => 'Jordanian Dinar',
                            'egy'   => 'Egyptian Pound',
                            'are'   => 'UAE Dirham',

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
            'pageCheckout'         => 'MyFatoorah - Checkout',
            'noPaymentGateways'    => 'There are no payment methods available on your account, please contact your account manager.',
            'howWouldYouLikeToPay' => 'How would you like to pay?',
            'or'                   => 'Or',
            'payWith'              => 'Pay With',
            'insertCardDetails'    => 'Insert Card Details',
            'payNow'               => 'Pay Now',
        ],

        'error' => [
            'pageError' => 'MyFatoorah Error',
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
