<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Beschrijving',
                        'logo'               => 'Logo',
                        'description'        => 'Veilig betalingssysteem met ondersteuning voor betaalmethoden, kaartgegevensopslag, terugbetalingsmogelijkheden en Webhook-integratie voor realtime statusupdates',
                        'api-key'            => 'API Sleutel',
                        'test-mode'          => 'Testmodus',
                        'country-iso'        => [
                            'title' => 'Land ISO',
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

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'Apple Pay koppelen',
                'description' => 'Apple Pay koppelen in de MyFatoorah-instellingen',
                'save-btn'    => 'Opslaan',
                'back-btn'    => 'Terug',
                'url'         => 'URL',
            ],
        ],

        'unexpected-payment' => 'MyFatoorah meldde betaling :transaction voor deze bestelling terwijl de status :status was. Controleer de betaling in MyFatoorah en betaal deze terug als ze niet nodig is.',
        'refund-failed'      => 'MyFatoorah kon :amount niet terugbetalen: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'MyFatoorah - Afrekenen',
            'no-payment-gateways'       => 'Er zijn geen betaalmethoden beschikbaar op uw account, neem contact op met uw accountmanager.',
            'how-would-you-like-to-pay' => 'Hoe wilt u betalen?',
            'or'                        => 'Of',
            'pay-with'                  => 'Betaal Met',
            'insert-card-details'       => 'Voer kaartgegevens in',
            'pay-now'                   => 'Nu Betalen',
            'cancel'                    => 'Annuleren',
            'invoice-success'           => 'Factuur is betaald.',
            'invoice-failed'            => 'Factuur is niet betaald vanwege :error',
            'method-unavailable'        => 'Deze betaalmethode is inactief, probeer een andere',
            'invalid-webhook-data'      => 'Ongeldige Webhook-gegevens',
            'no-webhook-signature'      => 'Webhook-handtekening niet beschikbaar.',
            'no-webhook-secretKey'      => 'Webhook geheime sleutel niet beschikbaar.',
            'invalid-webhook-signature' => 'Ongeldige Webhook-handtekening.',
            'error-occurred'            => 'Er is een fout opgetreden tijdens het verwerken van uw verzoek.',
            'error-title'               => 'Betalingsfout',
            'back-to-cart'              => 'Terug naar Winkelwagen',
            'invoice-pending'           => 'Uw betaling wordt nog verwerkt. Uw bestelling wordt bijgewerkt zodra MyFatoorah deze bevestigt.',
        ],

        'error'      => [
            'page-title' => 'MyFatoorah Fout',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'Naam op Kaart',
                'card-number'            => 'Nummer',
                'expiry-date'            => 'MM/JJ',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'Naam Kaarthouder',
                'card-number-label'      => 'Kaartnummer',
                'expiry-date-label'      => 'Vervaldatum',
                'security-code-label'    => 'Beveiligingscode',
                'save-card'              => 'Kaartnummer opslaan voor toekomstige betalingen',
                'add-card'               => 'Gebruik een andere kaart',
                'deleteAlert'            => [
                    'title'   => 'Kaart Verwijderen',
                    'message' => 'Weet u zeker dat u deze kaart wilt verwijderen?',
                    'confirm' => 'Ja',
                    'cancel'  => 'Nee',
                ],
            ],
        ],
    ],
];
