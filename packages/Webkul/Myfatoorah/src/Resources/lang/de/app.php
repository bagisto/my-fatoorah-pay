<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Beschreibung',
                        'logo'               => 'Logo',
                        'description'        => 'Sicheres Zahlungsmodul mit Unterstützung für Zahlungsmethoden, Kartendatenspeicherung, Rückerstattungsmöglichkeiten und Webhook-Integration für Echtzeit-Statusupdates',
                        'api-key'            => 'API-Schlüssel',
                        'test-mode'          => 'Testmodus',
                        'country-iso'        => [
                           'title'  => 'Länder-ISO',
                            'kwt'   => 'Kuwait',
                            'sau'   => 'Saudi-Arabien',
                            'qat'   => 'Katar',
                            'bhr'   => 'Bahrain',
                            'omn'   => 'Oman',
                            'jod'   => 'Jordanien',
                            'egy'   => 'Ägypten',
                            'are'   => 'Vereinigte Arabische Emirate',
                        ],
                        'is-webhook-enabled' => 'Webhook aktivieren',
                        'save-card'          => 'Karte speichern',
                        'webhook-secret-key' => 'Webhook Geheimschlüssel',
                        'register-apple-pay' => 'Apple Pay registrieren',
                        'status'             => 'Status',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'                => 'MyFatoorah - Kasse',
            'no-payment-gateways'       => 'Es sind keine Zahlungsmethoden auf Ihrem Konto verfügbar, bitte kontaktieren Sie Ihren Kontomanager.',
            'how-would-you-like-to-pay' => 'Wie möchten Sie bezahlen?',
            'or'                        => 'Oder',
            'pay-with'                  => 'Bezahlen mit',
            'insert-card-details'       => 'Kartendetails eingeben',
            'pay-now'                   => 'Jetzt bezahlen',
            'invoice-success'           => 'Rechnung bezahlt.',
            'invoice-failed'            => 'Rechnung wurde aufgrund von :error nicht bezahlt',
            'method-unavailable'        => 'Diese Zahlungsmethode ist inaktiv, bitte versuchen Sie eine andere',
            'invalid-webhook-data'      => 'Ungültige Webhook-Daten',
            'no-webhook-signature'      => 'Webhook-Signatur ist nicht verfügbar.',
            'no-webhook-secretKey'      => 'Webhook-Geheimschlüssel ist nicht verfügbar.',
            'invalid-webhook-signature' => 'Ungültige Webhook-Signatur.',
            'error-occurred'            => 'Beim Verarbeiten Ihrer Anfrage ist ein Fehler aufgetreten.',
            'error-title'               => 'Zahlungsfehler',
            'back-to-cart'              => 'Zurück zum Warenkorb',
        ],

        'error' => [
            'page-title' => 'MyFatoorah Fehler',
        ],

        'components' => [
            'form' => [
                'holder-name'           => 'Name auf der Karte',
                'card-number'           => 'Kartennummer',
                'expiry-date'           => 'Ablaufdatum',
                'security-code'         => 'Sicherheitscode',
                'card-holder-name-label'  => 'Karteninhabername',
                'card-number-label'      => 'Kartennummer',
                'expiry-date-label'      => 'Ablaufdatum',
                'security-code-label'    => 'Sicherheitscode',
                'save-card'             => 'Kartennummer für zukünftige Zahlungen speichern',
                'add-card'              => 'Andere Karte verwenden',
                'deleteAlert'          => [
                    'title'    => 'Karte löschen',
                    'message'  => 'Sind Sie sicher, dass Sie diese Karte entfernen möchten?',
                    'confirm'  => 'Ja',
                    'cancel'   => 'Nein',
                ],
            ],
        ],
    ],
];
