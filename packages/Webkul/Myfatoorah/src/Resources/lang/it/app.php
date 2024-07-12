<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Descrizione',
                        'logo'               => 'Logo',
                        'description'        => 'Modulo di pagamento sicuro con supporto per metodi di pagamento, archiviazione dei dati della carta, capacità di rimborso e integrazione Webhook per aggiornamenti di stato in tempo reale',
                        'api-key'            => 'Chiave API',
                        'test-mode'          => 'Modalità test',
                        'currency-iso'       => [
                            'title' => 'ISO della valuta',
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
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'MyFatoorah - Checkout',
            'noPaymentGateways'       => 'Non ci sono metodi di pagamento disponibili sul tuo account, si prega di contattare il proprio account manager.',
            'howWouldYouLikeToPay'    => 'Come desideri pagare?',
            'or'                      => 'Oppure',
            'payWith'                 => 'Paga con',
            'insertCardDetails'       => 'Inserisci i dati della carta',
            'payNow'                  => 'Paga ora',
            'invoice-success'         => 'Fattura pagata.',
            'invoice-failed'          => 'La fattura non è stata pagata a causa di :error',
            'method-unavailable'      => 'Questo metodo di pagamento è inattivo, si prega di provare un altro',
            'invalidWebhookData'      => 'Dati Webhook non validi',
            'noWebhookSignature'      => 'Firma Webhook non disponibile.',
            'noWebhookSecretKey'      => 'Chiave segreta Webhook non disponibile.',
            'invalidWebhookSignature' => 'Firma Webhook non valida.',
            'error-occurred'          => 'Si è verificato un errore durante l\'elaborazione della tua richiesta.',
        ],

        'error' => [
            'page-title' => 'Errore MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'Nome sulla carta',
                'cardNumber'           => 'Numero',
                'expiryDate'           => 'MM/AA',
                'securityCode'         => 'CVV',
                'cardHolderNameLabel'  => 'Nome del titolare della carta',
                'cardNumberLabel'      => 'Numero di carta',
                'expiryDateLabel'      => 'Data di scadenza',
                'securityCodeLabel'    => 'Codice di sicurezza',
                'saveCard'             => 'Salva numero di carta per pagamenti futuri',
                'addCard'              => 'Usa un\'altra carta',
                'deleteAlert'          => [
                    'title'    => 'Elimina carta',
                    'message'  => 'Sei sicuro di voler rimuovere questa carta?',
                    'confirm'  => 'Sì',
                    'cancel'   => 'No',
                ],
            ],
        ],
    ],
];
