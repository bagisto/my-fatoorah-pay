<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'payment-title' => 'Titel',
                        'description-title' => 'Beschrijving',
                        'logo' => 'Logo',
                        'description' => 'Veilig betalingssysteem met ondersteuning voor betaalmethoden, kaartgegevensopslag, terugbetalingsmogelijkheden en Webhook-integratie voor realtime statusupdates',
                        'api-key' => 'API Sleutel',
                        'test-mode' => 'Testmodus',
                        'country-iso' => [
                            'title' => 'Land ISO',
                            'kwt' => 'Koeweit',
                            'sau' => 'Saoedi-Arabië',
                            'qat' => 'Qatar',
                            'bhr' => 'Bahrein',
                            'omn' => 'Oman',
                            'jod' => 'Jordanië',
                            'egy' => 'Egypte',
                            'are' => 'Verenigde Arabische Emiraten',
                        ],
                        'is-webhook-enabled' => 'Webhook Inschakelen',
                        'webhook-secret-key' => 'Webhook Geheime Sleutel',
                        'status' => 'Status',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah kon :amount niet terugbetalen: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Afrekenen',
            'error-title' => 'Betalingsfout',
            'back-to-cart' => 'Terug naar Winkelwagen',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Configureer eerst uw MyFatoorah API-sleutel.',
        'cart-not-found' => 'Uw winkelwagen kon niet worden gevonden.',
        'payment-failed' => 'De betaling kon niet worden voltooid. Probeer het opnieuw.',
        'payment-success' => 'Uw betaling is gelukt!',
    ],
];
