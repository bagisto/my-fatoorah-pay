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
                        'country-iso'        => [
                            'title' => 'ISO del país',
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
            'page-title'                => 'MyFatoorah - Pagar',
            'no-payment-gateways'       => 'No hay métodos de pago disponibles en su cuenta, por favor contacte a su gerente de cuenta.',
            'how-would-you-like-to-pay' => '¿Cómo le gustaría pagar?',
            'or'                        => 'O',
            'pay-with'                  => 'Pagar con',
            'insert-card-details'       => 'Inserte los detalles de la tarjeta',
            'pay-now'                   => 'Pagar ahora',
            'invoice-success'           => 'Factura pagada.',
            'invoice-failed'            => 'La factura no se ha pagado debido a :error',
            'method-unavailable'        => 'Este método de pago está inactivo, por favor intente otro',
            'invalid-webhook-data'      => 'Datos de Webhook no válidos',
            'no-webhook-signature'      => 'Firma de Webhook no disponible.',
            'no-webhook-secretKey'      => 'Clave secreta de Webhook no disponible.',
            'invalid-webhook-signature' => 'Firma de Webhook no válida.',
            'error-occurred'            => 'Ocurrió un error mientras se procesaba su solicitud.',
            'error-title'               => 'Error de Pago',
            'back-to-cart'              => 'Volver al Carrito',
        ],

        'error' => [
            'page-title' => 'Error de MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'Nombre en la tarjeta',
                'card-number'            => 'Número',
                'expiry-date'            => 'MM/AA',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'Nombre del titular de la tarjeta',
                'card-number-label'      => 'Número de la tarjeta',
                'expiry-date-label'      => 'Fecha de expiración',
                'security-code-label'    => 'Código de seguridad',
                'save-card'              => 'Guardar número de tarjeta para pagos futuros',
                'add-card'               => 'Usar otra tarjeta',
                'deleteAlert'            => [
                    'title'    => 'Eliminar tarjeta',
                    'message'  => '¿Está seguro de que desea eliminar esta tarjeta?',
                    'confirm'  => 'Sí',
                    'cancel'   => 'No',
                ],
            ],
        ],
    ],
];
