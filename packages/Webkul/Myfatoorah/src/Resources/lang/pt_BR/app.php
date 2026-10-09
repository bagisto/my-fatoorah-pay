<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'payment-title' => 'Título',
                        'description-title' => 'Descrição',
                        'logo' => 'Logo',
                        'description' => 'Módulo de pagamento seguro com suporte a métodos de pagamento, armazenamento de dados de cartão, capacidade de reembolso e integração Webhook para atualizações de status em tempo real',
                        'api-key' => 'Chave API',
                        'test-mode' => 'Modo de Teste',
                        'country-iso' => [
                            'title' => 'ISO do país',
                            'kwt' => 'Kuwait',
                            'sau' => 'Arábia Saudita',
                            'qat' => 'Catar',
                            'bhr' => 'Bahrein',
                            'omn' => 'Omã',
                            'jod' => 'Jordânia',
                            'egy' => 'Egito',
                            'are' => 'Emirados Árabes Unidos',
                        ],
                        'is-webhook-enabled' => 'Habilitar Webhook',
                        'webhook-secret-key' => 'Chave Secreta Webhook',
                        'status' => 'Status',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'O MyFatoorah não conseguiu reembolsar :amount: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Checkout',
            'error-title' => 'Erro de Pagamento',
            'back-to-cart' => 'Voltar ao Carrinho',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Configure primeiro sua chave de API do MyFatoorah.',
        'cart-not-found' => 'Seu carrinho não foi encontrado.',
        'payment-failed' => 'Não foi possível concluir o pagamento. Tente novamente.',
        'payment-success' => 'Seu pagamento foi realizado com sucesso!',
    ],
];
