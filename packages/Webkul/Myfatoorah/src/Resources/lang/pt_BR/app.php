<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Descrição',
                        'logo'               => 'Logo',
                        'description'        => 'Módulo de pagamento seguro com suporte a métodos de pagamento, armazenamento de dados de cartão, capacidade de reembolso e integração Webhook para atualizações de status em tempo real',
                        'api-key'            => 'Chave API',
                        'test-mode'          => 'Modo de Teste',
                        'country-iso'       => [
                            'title' => 'ISO do país',
                            'kwt'   => 'Kuwait',
                            'sau'   => 'Arábia Saudita',
                            'qat'   => 'Catar',
                            'bhr'   => 'Bahrein',
                            'omn'   => 'Omã',
                            'jod'   => 'Jordânia',
                            'egy'   => 'Egito',
                            'are'   => 'Emirados Árabes Unidos',
                        ],
                        'is-webhook-enabled' => 'Habilitar Webhook',
                        'save-card'          => 'Salvar Cartão',
                        'webhook-secret-key' => 'Chave Secreta Webhook',
                        'register-apple-pay' => 'Registrar Apple Pay',
                        'status'             => 'Status',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'MyFatoorah - Checkout',
            'noPaymentGateways'       => 'Não há métodos de pagamento disponíveis na sua conta, por favor entre em contato com o gerente da sua conta.',
            'howWouldYouLikeToPay'    => 'Como você gostaria de pagar?',
            'or'                      => 'Ou',
            'payWith'                 => 'Pagar com',
            'insertCardDetails'       => 'Insira os detalhes do cartão',
            'payNow'                  => 'Pague Agora',
            'invoice-success'         => 'A fatura foi paga.',
            'invoice-failed'          => 'A fatura não foi paga devido a :error',
            'method-unavailable'      => 'Este método de pagamento está inativo, por favor tente outro',
            'invalidWebhookData'      => 'Dados Webhook inválidos',
            'noWebhookSignature'      => 'Assinatura Webhook não disponível.',
            'noWebhookSecretKey'      => 'Chave secreta Webhook não disponível.',
            'invalidWebhookSignature' => 'Assinatura Webhook inválida.',
            'error-occurred'          => 'Ocorreu um erro ao processar sua solicitação.',
        ],

        'error' => [
            'page-title' => 'Erro MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'Nome no Cartão',
                'cardNumber'           => 'Número',
                'expiryDate'           => 'MM/AA',
                'securityCode'         => 'CVV',
                'cardHolderNameLabel'  => 'Nome do Titular do Cartão',
                'cardNumberLabel'      => 'Número do Cartão',
                'expiryDateLabel'      => 'Data de Validade',
                'securityCodeLabel'    => 'Código de Segurança',
                'saveCard'             => 'Salvar número do cartão para pagamentos futuros',
                'addCard'              => 'Usar outro cartão',
                'deleteAlert'          => [
                    'title'    => 'Excluir Cartão',
                    'message'  => 'Tem certeza de que deseja remover este cartão?',
                    'confirm'  => 'Sim',
                    'cancel'   => 'Não',
                ],
            ],
        ],
    ],
];
