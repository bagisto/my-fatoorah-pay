<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Descripción',
                        'logo'               => 'Logotipo',
                        'description'        => 'Módulo de pago seguro con soporte para métodos de pago, almacenamiento de datos de tarjetas, capacidades de reembolso e integración de Webhook para actualizaciones de estado en tiempo real',
                        'api-key'            => 'Clave API',
                        'test-mode'          => 'Modo de prueba',
                        'currency-iso'       => [
                            'title' => 'Moneda ISO',
                            'kwt'   => 'Kuwait',
                            'sau'   => 'Arabia Saudita',
                            'qat'   => 'Catar',
                            'bhr'   => 'Baréin',
                            'omn'   => 'Omán',
                            'jod'   => 'Jordania',
                            'egy'   => 'Egipto',
                            'are'   => 'Emiratos Árabes Unidos',
                        ],
                        'is-webhook-enabled' => 'Habilitar Webhook',
                        'save-card'          => 'Guardar tarjeta',
                        'webhook-secret-key' => 'Clave secreta de Webhook',
                        'register-apple-pay' => 'Registrar Apple Pay',
                        'status'             => 'Estado',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'MyFatoorah - Pagar',
            'noPaymentGateways'       => 'No hay métodos de pago disponibles en su cuenta, por favor contacte a su gerente de cuenta.',
            'howWouldYouLikeToPay'    => '¿Cómo le gustaría pagar?',
            'or'                      => 'O',
            'payWith'                 => 'Pagar con',
            'insertCardDetails'       => 'Inserte los detalles de la tarjeta',
            'payNow'                  => 'Pagar ahora',
            'invoice-success'         => 'Factura pagada.',
            'invoice-failed'          => 'La factura no se ha pagado debido a :error',
            'method-unavailable'      => 'Este método de pago está inactivo, por favor intente otro',
            'invalidWebhookData'      => 'Datos de Webhook no válidos',
            'noWebhookSignature'      => 'Firma de Webhook no disponible.',
            'noWebhookSecretKey'      => 'Clave secreta de Webhook no disponible.',
            'invalidWebhookSignature' => 'Firma de Webhook no válida.',
            'error-occurred'          => 'Ocurrió un error mientras se procesaba su solicitud.',
        ],

        'error' => [
            'page-title' => 'Error de MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'Nombre en la tarjeta',
                'cardNumber'           => 'Número',
                'expiryDate'           => 'MM/AA',
                'securityCode'         => 'CVV',
                'cardHolderNameLabel'  => 'Nombre del titular de la tarjeta',
                'cardNumberLabel'      => 'Número de la tarjeta',
                'expiryDateLabel'      => 'Fecha de expiración',
                'securityCodeLabel'    => 'Código de seguridad',
                'saveCard'             => 'Guardar número de tarjeta para pagos futuros',
                'addCard'              => 'Usar otra tarjeta',
                'deleteAlert'          => [
                    'title'    => 'Eliminar tarjeta',
                    'message'  => '¿Está seguro de que desea eliminar esta tarjeta?',
                    'confirm'  => 'Sí',
                    'cancel'   => 'No',
                ],
            ],
        ],
    ],
];
