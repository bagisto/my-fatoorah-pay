<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description'        => 'Veilig betalingssysteem met ondersteuning voor betaalmethoden, kaartgegevensopslag, terugbetalingsmogelijkheden en Webhook-integratie voor realtime statusupdates',
                        'api-key'            => 'API Sleutel',
                        'test-mode'          => 'Testmodus',
                        'currency-iso'       => [
                            'title' => 'Valuta ISO',
                            'kwt'   => 'Koeweit',
                            'sau'   => 'Saoedi-Arabië',
                            'qat'   => 'Qatar',
                            'bhr'   => 'Bahrein',
                            'omn'   => 'Oman',
                            'jod'   => 'Jordanië',
                            'egy'   => 'Egypte',
                            'are'   => 'Verenigde Arabische Emiraten',
                        ],
                        'is-webhook-enabled' => 'Webhook Inschakelen',
                        'save-card'          => 'Kaart Opslaan',
                        'webhook-secret-key' => 'Webhook Geheime Sleutel',
                        'register-apple-pay' => 'Registreer Apple Pay',
                        'status'             => 'Status',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'MyFatoorah - Afrekenen',
            'noPaymentGateways'       => 'Er zijn geen betaalmethoden beschikbaar op uw account, neem contact op met uw accountmanager.',
            'howWouldYouLikeToPay'    => 'Hoe wilt u betalen?',
            'or'                      => 'Of',
            'payWith'                 => 'Betaal Met',
            'insertCardDetails'       => 'Voer kaartgegevens in',
            'payNow'                  => 'Nu Betalen',
            'invoice-success'         => 'Factuur is betaald.',
            'invoice-failed'          => 'Factuur is niet betaald vanwege :error',
            'method-unavailable'      => 'Deze betaalmethode is inactief, probeer een andere',
            'invalidWebhookData'      => 'Ongeldige Webhook-gegevens',
            'noWebhookSignature'      => 'Webhook-handtekening niet beschikbaar.',
            'noWebhookSecretKey'      => 'Webhook geheime sleutel niet beschikbaar.',
            'invalidWebhookSignature' => 'Ongeldige Webhook-handtekening.',
        ],

        'error' => [
            'page-title' => 'MyFatoorah Fout',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'Naam op Kaart',
                'cardNumber'           => 'Nummer',
                'expiryDate'           => 'MM/JJ',
                'securityCode'         => 'CVV',
                'cardHolderNameLabel'  => 'Naam Kaarthouder',
                'cardNumberLabel'      => 'Kaartnummer',
                'expiryDateLabel'      => 'Vervaldatum',
                'securityCodeLabel'    => 'Beveiligingscode',
                'saveCard'             => 'Kaartnummer opslaan voor toekomstige betalingen',
                'addCard'              => 'Gebruik een andere kaart',
                'deleteAlert'          => [
                    'title'    => 'Kaart Verwijderen',
                    'message'  => 'Weet u zeker dat u deze kaart wilt verwijderen?',
                    'confirm'  => 'Ja',
                    'cancel'   => 'Nee',
                ],
            ],
        ],
    ],
];
