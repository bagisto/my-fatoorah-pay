<?php

return [
    [
        'key'    => 'sales.payment_methods.myfatoorah',
        'name'   => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.title',
        'info'   => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.description',
        'sort'   => 5,
        'fields' => [
            [
                'name'          => 'status',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.status',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'          => 'logo',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.logo',
                'type'          => 'image',
                'channel_based' => true,
                'locale_based'  => false,
                'validation'    => 'mimes:bmp,jpeg,jpg,png,webp',
            ], [
                'name'          => 'api_key',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.api-key',
                'type'          => 'text',
                'validation'    => 'required_if:active,1',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'          => 'test_mode',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.test-mode',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'          => 'country_iso',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.country-iso.title',
                'type'          => 'select',
                'channel_based' => true,
                'validation'    => 'required',
                'locale_based'  => false,
                'options'       => [
                    [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.country-iso.kwt',
                        'value' => 'KWT',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.country-iso.sau',
                        'value' => 'SAU',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.country-iso.are',
                        'value' => 'ARE',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.country-iso.qat',
                        'value' => 'QAT',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.country-iso.bhr',
                        'value' => 'BHR',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.country-iso.omn',
                        'value' => 'OMN',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.country-iso.jod',
                        'value' => 'JOD',
                    ], [
                        'title' => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.country-iso.egy',
                        'value' => 'EGY',
                    ],

                ],
            ], [
                'name'          => 'save_card',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.save-card',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'          => 'is_webhook_enabled',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.is-webhook-enabled',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'          => 'webhook_secret_key',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.webhook-secret-key',
                'type'          => 'text',
                'depends'       => 'is_webhook_enabled:1',
                'validation'    => 'required_if:is_webhook_enabled,1',
                'info'          => url('myfatoorah/webhook'),
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'          => 'register_apple_pay',
                'title'         => 'my_fatoorah::app.admin.configurations.index.sales.payment-methods.register-apple-pay',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ],
        ],
    ],
];
