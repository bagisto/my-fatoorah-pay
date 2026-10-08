<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Descrizione',
                        'logo'               => 'Logo',
                        'description'        => 'Modulo di pagamento sicuro con supporto per metodi di pagamento, archiviazione dei dati della carta, capacità di rimborso e integrazione Webhook per aggiornamenti di stato in tempo reale',
                        'api-key'            => 'Chiave API',
                        'test-mode'          => 'Modalità test',
                        'country-iso'        => [
                            'title' => 'ISO del paese',
                            'kwt'   => 'Kuwait',
                            'sau'   => 'Arabia Saudita',
                            'qat'   => 'Qatar',
                            'bhr'   => 'Bahrein',
                            'omn'   => 'Oman',
                            'jod'   => 'Giordania',
                            'egy'   => 'Egitto',
                            'are'   => 'Emirati Arabi Uniti',
                        ],
                        'is-webhook-enabled' => 'Abilita Webhook',
                        'save-card'          => 'Salva carta',
                        'webhook-secret-key' => 'Chiave segreta Webhook',
                        'register-apple-pay' => 'Registra Apple Pay',
                        'status'             => 'Stato',
                    ],
                ],
            ],
        ],

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'Collega Apple Pay',
                'description' => 'Collega Apple Pay nelle impostazioni di MyFatoorah',
                'save-btn'    => 'Salva',
                'back-btn'    => 'Indietro',
                'url'         => 'URL',
            ],
        ],

        'unexpected-payment' => 'MyFatoorah ha segnalato il pagamento :transaction per questo ordine mentre il suo stato era :status. Verifica il pagamento in MyFatoorah e rimborsalo se non è necessario.',
        'refund-failed'      => 'MyFatoorah non è riuscito a rimborsare :amount: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'MyFatoorah - Checkout',
            'no-payment-gateways'       => 'Non ci sono metodi di pagamento disponibili sul tuo account, si prega di contattare il proprio account manager.',
            'how-would-you-like-to-pay' => 'Come desideri pagare?',
            'or'                        => 'Oppure',
            'pay-with'                  => 'Paga con',
            'insert-card-details'       => 'Inserisci i dati della carta',
            'pay-now'                   => 'Paga ora',
            'cancel'                    => 'Annulla',
            'invoice-success'           => 'Fattura pagata.',
            'invoice-failed'            => 'La fattura non è stata pagata a causa di :error',
            'method-unavailable'        => 'Questo metodo di pagamento è inattivo, si prega di provare un altro',
            'invalid-webhook-data'      => 'Dati Webhook non validi',
            'no-webhook-signature'      => 'Firma Webhook non disponibile.',
            'no-webhook-secretKey'      => 'Chiave segreta Webhook non disponibile.',
            'invalid-webhook-signature' => 'Firma Webhook non valida.',
            'error-occurred'            => 'Si è verificato un errore durante l\'elaborazione della tua richiesta.',
            'error-title'               => 'Errore di Pagamento',
            'back-to-cart'              => 'Torna al Carrello',
            'invoice-pending'           => 'Il tuo pagamento è ancora in elaborazione. Il tuo ordine verrà aggiornato non appena MyFatoorah lo confermerà.',
        ],

        'error'      => [
            'page-title' => 'Errore MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'Nome sulla carta',
                'card-number'            => 'Numero',
                'expiry-date'            => 'MM/AA',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'Nome del titolare della carta',
                'card-number-label'      => 'Numero di carta',
                'expiry-date-label'      => 'Data di scadenza',
                'security-code-label'    => 'Codice di sicurezza',
                'save-card'              => 'Salva numero di carta per pagamenti futuri',
                'add-card'               => 'Usa un\'altra carta',
                'deleteAlert'            => [
                    'title'   => 'Elimina carta',
                    'message' => 'Sei sicuro di voler rimuovere questa carta?',
                    'confirm' => 'Sì',
                    'cancel'  => 'No',
                ],
            ],
        ],
    ],
];
