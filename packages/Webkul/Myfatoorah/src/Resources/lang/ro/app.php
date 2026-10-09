<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'description-title' => 'Descriere',
                        'logo' => 'Siglă',
                        'description' => 'Modulul de plată MyFatoorah permite plata prin mai multe opțiuni, precum Apple Pay, Google Pay și carduri de credit și de debit.',
                        'api-key' => 'Cheie API',
                        'test-mode' => 'Mod de test',
                        'country-iso' => [
                            'title' => 'Țară (ISO)',
                            'kwt' => 'Kuweit',
                            'sau' => 'Arabia Saudită',
                            'qat' => 'Qatar',
                            'bhr' => 'Bahrain',
                            'omn' => 'Oman',
                            'jod' => 'Iordania',
                            'egy' => 'Egipt',
                            'are' => 'Emiratele Arabe Unite',
                        ],
                        'is-webhook-enabled' => 'Activează webhook-ul',
                        'webhook-secret-key' => 'Cheia secretă a webhook-ului',
                        'status' => 'Stare',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah nu a putut rambursa :amount: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Finalizare comandă',
            'error-title' => 'Eroare de plată',
            'back-to-cart' => 'Înapoi la coș',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Configurați mai întâi cheia API MyFatoorah.',
        'cart-not-found' => 'Coșul dvs. nu a putut fi găsit.',
        'payment-failed' => 'Plata nu a putut fi finalizată. Vă rugăm să încercați din nou.',
        'payment-success' => 'Plata dvs. a fost efectuată cu succes!',
    ],
];
