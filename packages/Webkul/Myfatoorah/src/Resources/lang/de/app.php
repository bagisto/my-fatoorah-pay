<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'payment-title' => 'Titel',
                        'description-title' => 'Beschreibung',
                        'logo' => 'Logo',
                        'description' => 'Sicheres Zahlungsmodul mit Unterstützung für Zahlungsmethoden, Kartendatenspeicherung, Rückerstattungsmöglichkeiten und Webhook-Integration für Echtzeit-Statusupdates',
                        'api-key' => 'API-Schlüssel',
                        'test-mode' => 'Testmodus',
                        'country-iso' => [
                            'title' => 'Länder-ISO',
                            'kwt' => 'Kuwait',
                            'sau' => 'Saudi-Arabien',
                            'qat' => 'Katar',
                            'bhr' => 'Bahrain',
                            'omn' => 'Oman',
                            'jod' => 'Jordanien',
                            'egy' => 'Ägypten',
                            'are' => 'Vereinigte Arabische Emirate',
                        ],
                        'is-webhook-enabled' => 'Webhook aktivieren',
                        'webhook-secret-key' => 'Webhook Geheimschlüssel',
                        'status' => 'Status',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah konnte :amount nicht erstatten: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Kasse',
            'error-title' => 'Zahlungsfehler',
            'back-to-cart' => 'Zurück zum Warenkorb',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Bitte konfigurieren Sie zuerst Ihren MyFatoorah API-Schlüssel.',
        'cart-not-found' => 'Ihr Warenkorb konnte nicht gefunden werden.',
        'payment-failed' => 'Die Zahlung konnte nicht abgeschlossen werden. Bitte versuchen Sie es erneut.',
        'payment-success' => 'Ihre Zahlung war erfolgreich!',
    ],
];
