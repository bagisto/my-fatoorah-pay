<?php

return [
    [
        'key'    => 'sales.payment_methods.myfatoorah',
        'name'   => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.title',
        'info'   => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.description',
        'sort'   => 5,
        'fields' => [
            [
                'name'          => 'api_key',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.api-key',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'test_mode',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.test-mode',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'country_iso',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.currency-iso.title',
                'type'          => 'select',
                'channel_based' => true,
                'locale_based'  => true,
                'options'       => [
                    [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.currency-iso.kwt',
                        'value' => 'KWT',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.currency-iso.sau',
                        'value' => 'SAU',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.currency-iso.are',
                        'value' => 'ARE',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.currency-iso.qat',
                        'value' => 'QAT',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.currency-iso.bhr',
                        'value' => 'BHR',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.currency-iso.omn',
                        'value' => 'OMN',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.currency-iso.jod',
                        'value' => 'JOD',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.currency-iso.egy',
                        'value' => 'EGY',
                    ],

                ],

            ], [
                'name'          => 'save_card',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.save-card',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'webhook_secret_key',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.webhook-secret-key',
                'type'          => 'text',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name'          => 'register_apple_pay',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.register-apple-pay',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => true,
            ],
        ],
    ],
];
