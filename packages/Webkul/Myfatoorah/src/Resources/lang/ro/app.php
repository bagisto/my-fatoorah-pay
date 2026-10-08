<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Descriere',
                        'logo'               => 'Siglă',
                        'description'        => 'Modulul de plată MyFatoorah permite plata prin mai multe opțiuni, precum Apple Pay, Google Pay și carduri de credit și de debit.',
                        'api-key'            => 'Cheie API',
                        'test-mode'          => 'Mod de test',
                        'country-iso'        => [
                            'title' => 'Țară (ISO)',
                            'kwt'   => 'Kuweit',
                            'sau'   => 'Arabia Saudită',
                            'qat'   => 'Qatar',
                            'bhr'   => 'Bahrain',
                            'omn'   => 'Oman',
                            'jod'   => 'Iordania',
                            'egy'   => 'Egipt',
                            'are'   => 'Emiratele Arabe Unite',
                        ],
                        'is-webhook-enabled' => 'Activează webhook-ul',
                        'save-card'          => 'Salvează cardul',
                        'webhook-secret-key' => 'Cheia secretă a webhook-ului',
                        'register-apple-pay' => 'Înregistrează Apple Pay',
                        'status'             => 'Stare',
                    ],
                ],
            ],
        ],

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'Asociază Apple Pay',
                'description' => 'Asociază Apple Pay în setările MyFatoorah',
                'save-btn'    => 'Salvează',
                'back-btn'    => 'Înapoi',
                'url'         => 'URL',
            ],
        ],

        'unexpected-payment' => 'MyFatoorah a raportat plata :transaction pentru această comandă când starea ei era :status. Verificați plata în MyFatoorah și rambursați-o dacă nu este necesară.',
        'refund-failed'      => 'MyFatoorah nu a putut rambursa :amount: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'MyFatoorah - Finalizare comandă',
            'no-payment-gateways'       => 'Nu există metode de plată disponibile în contul dvs., vă rugăm să contactați managerul de cont.',
            'how-would-you-like-to-pay' => 'Cum doriți să plătiți?',
            'or'                        => 'Sau',
            'pay-with'                  => 'Plătiți cu',
            'insert-card-details'       => 'Introduceți datele cardului',
            'pay-now'                   => 'Plătiți acum',
            'cancel'                    => 'Anulează',
            'invoice-success'           => 'Factura a fost plătită.',
            'invoice-failed'            => 'Factura nu a fost plătită din cauza: :error',
            'method-unavailable'        => 'Această metodă de plată este inactivă, vă rugăm să încercați alta',
            'invalid-webhook-data'      => 'Date webhook nevalide',
            'no-webhook-signature'      => 'Semnătura webhook-ului nu este disponibilă.',
            'no-webhook-secretKey'      => 'Cheia secretă a webhook-ului nu este disponibilă.',
            'invalid-webhook-signature' => 'Semnătura webhook-ului nu este validă.',
            'error-occurred'            => 'A apărut o eroare la procesarea solicitării dvs.',
            'error-title'               => 'Eroare de plată',
            'back-to-cart'              => 'Înapoi la coș',
            'invoice-pending'           => 'Plata dvs. este încă în curs de procesare. Comanda va fi actualizată imediat ce MyFatoorah o confirmă.',
        ],

        'error'      => [
            'page-title' => 'Eroare MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'Numele de pe card',
                'card-number'            => 'Număr',
                'expiry-date'            => 'LL/AA',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'Numele titularului cardului',
                'card-number-label'      => 'Numărul cardului',
                'expiry-date-label'      => 'Data expirării',
                'security-code-label'    => 'Cod de securitate',
                'save-card'              => 'Salvează numărul cardului pentru plăți viitoare',
                'add-card'               => 'Folosește alt card',
                'deleteAlert'            => [
                    'title'   => 'Șterge cardul',
                    'message' => 'Sigur doriți să eliminați acest card?',
                    'confirm' => 'Da',
                    'cancel'  => 'Nu',
                ],
            ],
        ],
    ],
];
