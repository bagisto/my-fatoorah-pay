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
                        'currency-iso'       => [
                            'title' => 'Währungs-ISO',
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
            'page-title'              => 'MyFatoorah - Kasse',
            'noPaymentGateways'       => 'Es sind keine Zahlungsmethoden auf Ihrem Konto verfügbar, bitte kontaktieren Sie Ihren Kontomanager.',
            'howWouldYouLikeToPay'    => 'Wie möchten Sie bezahlen?',
            'or'                      => 'Oder',
            'payWith'                 => 'Bezahlen mit',
            'insertCardDetails'       => 'Kartendetails eingeben',
            'payNow'                  => 'Jetzt bezahlen',
            'invoice-success'         => 'Rechnung bezahlt.',
            'invoice-failed'          => 'Rechnung wurde aufgrund von :error nicht bezahlt',
            'method-unavailable'      => 'Diese Zahlungsmethode ist inaktiv, bitte versuchen Sie eine andere',
            'invalidWebhookData'      => 'Ungültige Webhook-Daten',
            'noWebhookSignature'      => 'Webhook-Signatur ist nicht verfügbar.',
            'noWebhookSecretKey'      => 'Webhook-Geheimschlüssel ist nicht verfügbar.',
            'invalidWebhookSignature' => 'Ungültige Webhook-Signatur.',
            'error-occurred'          => 'Beim Verarbeiten Ihrer Anfrage ist ein Fehler aufgetreten.',
        ],

        'error' => [
            'page-title' => 'MyFatoorah Fehler',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'Name auf der Karte',
                'cardNumber'           => 'Kartennummer',
                'expiryDate'           => 'Ablaufdatum',
                'securityCode'         => 'Sicherheitscode',
                'cardHolderNameLabel'  => 'Karteninhabername',
                'cardNumberLabel'      => 'Kartennummer',
                'expiryDateLabel'      => 'Ablaufdatum',
                'securityCodeLabel'    => 'Sicherheitscode',
                'saveCard'             => 'Kartennummer für zukünftige Zahlungen speichern',
                'addCard'              => 'Andere Karte verwenden',
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
