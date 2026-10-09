<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'description-title' => 'Descrizione',
                        'logo' => 'Logo',
                        'description' => 'Modulo di pagamento sicuro con supporto per metodi di pagamento, archiviazione dei dati della carta, capacità di rimborso e integrazione Webhook per aggiornamenti di stato in tempo reale',
                        'api-key' => 'Chiave API',
                        'test-mode' => 'Modalità test',
                        'country-iso' => [
                            'title' => 'ISO del paese',
                            'kwt' => 'Kuwait',
                            'sau' => 'Arabia Saudita',
                            'qat' => 'Qatar',
                            'bhr' => 'Bahrein',
                            'omn' => 'Oman',
                            'jod' => 'Giordania',
                            'egy' => 'Egitto',
                            'are' => 'Emirati Arabi Uniti',
                        ],
                        'is-webhook-enabled' => 'Abilita Webhook',
                        'webhook-secret-key' => 'Chiave segreta Webhook',
                        'status' => 'Stato',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah non è riuscito a rimborsare :amount: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Checkout',
            'error-title' => 'Errore di Pagamento',
            'back-to-cart' => 'Torna al Carrello',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Configura prima la tua chiave API MyFatoorah.',
        'cart-not-found' => 'Il tuo carrello non è stato trovato.',
        'payment-failed' => 'Il pagamento non può essere completato. Riprova.',
        'payment-success' => 'Il tuo pagamento è andato a buon fine!',
    ],
];
