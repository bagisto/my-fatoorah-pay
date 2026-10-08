<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Descripció',
                        'logo'               => 'Logotip',
                        'description'        => 'El mòdul de pagament MyFatoorah permet pagar amb diverses opcions com Apple Pay, Google Pay i targetes de crèdit i dèbit.',
                        'api-key'            => 'Clau de l\'API',
                        'test-mode'          => 'Mode de prova',
                        'country-iso'        => [
                            'title' => 'País (ISO)',
                            'kwt'   => 'Kuwait',
                            'sau'   => 'Aràbia Saudita',
                            'qat'   => 'Qatar',
                            'bhr'   => 'Bahrain',
                            'omn'   => 'Oman',
                            'jod'   => 'Jordània',
                            'egy'   => 'Egipte',
                            'are'   => 'Emirats Àrabs Units',
                        ],
                        'is-webhook-enabled' => 'Activa el webhook',
                        'save-card'          => 'Desa la targeta',
                        'webhook-secret-key' => 'Clau secreta del webhook',
                        'register-apple-pay' => 'Registra Apple Pay',
                        'status'             => 'Estat',
                    ],
                ],
            ],
        ],

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'Vincula Apple Pay',
                'description' => 'Vincula Apple Pay a la configuració de MyFatoorah',
                'save-btn'    => 'Desa',
                'back-btn'    => 'Enrere',
                'url'         => 'URL',
            ],
        ],

        'unexpected-payment' => 'MyFatoorah ha notificat el pagament :transaction per a aquesta comanda quan el seu estat era :status. Comproveu el pagament a MyFatoorah i reemborseu-lo si no és necessari.',
        'refund-failed'      => 'MyFatoorah no ha pogut reemborsar :amount: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'MyFatoorah - Pagament',
            'no-payment-gateways'       => 'El vostre compte no té cap mètode de pagament disponible. Poseu-vos en contacte amb el vostre gestor de compte.',
            'how-would-you-like-to-pay' => 'Com voleu pagar?',
            'or'                        => 'O',
            'pay-with'                  => 'Paga amb',
            'insert-card-details'       => 'Introduïu les dades de la targeta',
            'pay-now'                   => 'Paga ara',
            'cancel'                    => 'Cancel·la',
            'invoice-success'           => 'La factura s\'ha pagat.',
            'invoice-failed'            => 'La factura no s\'ha pagat a causa de :error',
            'method-unavailable'        => 'Aquest mètode de pagament està inactiu. Proveu-ne un altre.',
            'invalid-webhook-data'      => 'Dades del webhook no vàlides',
            'no-webhook-signature'      => 'La signatura del webhook no està disponible.',
            'no-webhook-secretKey'      => 'La clau secreta del webhook no està disponible.',
            'invalid-webhook-signature' => 'La signatura del webhook no és vàlida.',
            'error-occurred'            => 'S\'ha produït un error en processar la vostra sol·licitud.',
            'error-title'               => 'Error de pagament',
            'back-to-cart'              => 'Torna a la cistella',
            'invoice-pending'           => 'El vostre pagament encara s\'està processant. La comanda s\'actualitzarà tan aviat com MyFatoorah el confirmi.',
        ],

        'error'      => [
            'page-title' => 'Error de MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'Nom a la targeta',
                'card-number'            => 'Número',
                'expiry-date'            => 'MM/AA',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'Nom del titular de la targeta',
                'card-number-label'      => 'Número de targeta',
                'expiry-date-label'      => 'Data de caducitat',
                'security-code-label'    => 'Codi de seguretat',
                'save-card'              => 'Desa el número de targeta per a pagaments futurs',
                'add-card'               => 'Utilitza una altra targeta',
                'deleteAlert'            => [
                    'title'   => 'Elimina la targeta',
                    'message' => 'Segur que voleu eliminar aquesta targeta?',
                    'confirm' => 'Sí',
                    'cancel'  => 'No',
                ],
            ],
        ],
    ],
];
