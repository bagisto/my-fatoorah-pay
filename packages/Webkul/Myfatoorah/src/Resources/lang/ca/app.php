<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'payment-title' => 'Títol',
                        'description-title' => 'Descripció',
                        'logo' => 'Logotip',
                        'description' => 'El mòdul de pagament MyFatoorah permet pagar amb diverses opcions com Apple Pay, Google Pay i targetes de crèdit i dèbit.',
                        'api-key' => 'Clau de l\'API',
                        'test-mode' => 'Mode de prova',
                        'country-iso' => [
                            'title' => 'País (ISO)',
                            'kwt' => 'Kuwait',
                            'sau' => 'Aràbia Saudita',
                            'qat' => 'Qatar',
                            'bhr' => 'Bahrain',
                            'omn' => 'Oman',
                            'jod' => 'Jordània',
                            'egy' => 'Egipte',
                            'are' => 'Emirats Àrabs Units',
                        ],
                        'is-webhook-enabled' => 'Activa el webhook',
                        'webhook-secret-key' => 'Clau secreta del webhook',
                        'status' => 'Estat',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah no ha pogut reemborsar :amount: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Pagament',
            'error-title' => 'Error de pagament',
            'back-to-cart' => 'Torna a la cistella',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Si us plau, configura primer la teva clau API de MyFatoorah.',
        'cart-not-found' => 'No s\'ha pogut trobar la teva cistella.',
        'payment-failed' => 'No s\'ha pogut completar el pagament. Si us plau, torna-ho a provar.',
        'payment-success' => 'El teu pagament s\'ha realitzat correctament!',
    ],
];
