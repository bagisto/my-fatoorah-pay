<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'description-title' => 'Descripción',
                        'logo' => 'Logotipo',
                        'description' => 'Módulo de pago seguro con soporte para métodos de pago, almacenamiento de datos de tarjetas, capacidades de reembolso e integración de Webhook para actualizaciones de estado en tiempo real',
                        'api-key' => 'Clave API',
                        'test-mode' => 'Modo de prueba',
                        'country-iso' => [
                            'title' => 'ISO del país',
                            'kwt' => 'Kuwait',
                            'sau' => 'Arabia Saudita',
                            'qat' => 'Catar',
                            'bhr' => 'Baréin',
                            'omn' => 'Omán',
                            'jod' => 'Jordania',
                            'egy' => 'Egipto',
                            'are' => 'Emiratos Árabes Unidos',
                        ],
                        'is-webhook-enabled' => 'Habilitar Webhook',
                        'webhook-secret-key' => 'Clave secreta de Webhook',
                        'status' => 'Estado',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah no pudo reembolsar :amount: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Pagar',
            'error-title' => 'Error de Pago',
            'back-to-cart' => 'Volver al Carrito',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Por favor, configure primero su clave API de MyFatoorah.',
        'cart-not-found' => 'No se pudo encontrar su carrito.',
        'payment-failed' => 'No se pudo completar el pago. Por favor, inténtelo de nuevo.',
        'payment-success' => '¡Su pago se ha realizado correctamente!',
    ],
];
