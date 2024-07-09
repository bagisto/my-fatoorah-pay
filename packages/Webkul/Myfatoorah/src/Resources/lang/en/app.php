<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'api-key' => 'API Key',
                        'test-mode' => 'Test Mode',
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
                        'save-card' => 'Save Card',
                        'webhook-secret-key' => 'Webhook Secret Key',
                        'register-apple-pay' => 'Register Apple Pay',
                    ],
                ],
            ],
        ],
    ],

    'checkout' => [
        'pageCheckout'         => 'MyFatoorah - Checkout',
        'pageError'            => 'MyFatoorah Error',
        'noPaymentGateways'    => 'There are no payment methods available on your account, please contact your account manager.',
        'howWouldYouLikeToPay' => 'How would you like to pay?',
        'or'                   => 'Or',
        'payWith'              => 'Pay With',
        'insertCardDetails'    => 'Insert Card Details',
        'payNow'               => 'Pay Now',
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
        'deleteAlert' => [
            'title'    => 'Delete Card',
            'message'  => 'Are you sure you want to remove this card?',
            'confirm'  => 'Yes',
            'cancel'   => 'No',
        ]
    ],
];