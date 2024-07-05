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
];