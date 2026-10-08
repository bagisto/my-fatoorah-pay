<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Descrição',
                        'logo'               => 'Logo',
                        'description'        => 'Módulo de pagamento seguro com suporte a métodos de pagamento, armazenamento de dados de cartão, capacidade de reembolso e integração Webhook para atualizações de status em tempo real',
                        'api-key'            => 'Chave API',
                        'test-mode'          => 'Modo de Teste',
                        'country-iso'        => [
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

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'Vincular Apple Pay',
                'description' => 'Vincular Apple Pay nas configurações do MyFatoorah',
                'save-btn'    => 'Salvar',
                'back-btn'    => 'Voltar',
                'url'         => 'URL',
            ],
        ],

        'unexpected-payment' => 'O MyFatoorah informou o pagamento :transaction para este pedido quando o status era :status. Verifique o pagamento no MyFatoorah e reembolse-o se não for necessário.',
        'refund-failed'      => 'O MyFatoorah não conseguiu reembolsar :amount: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'MyFatoorah - Checkout',
            'no-payment-gateways'       => 'Não há métodos de pagamento disponíveis na sua conta, por favor entre em contato com o gerente da sua conta.',
            'how-would-you-like-to-pay' => 'Como você gostaria de pagar?',
            'or'                        => 'Ou',
            'pay-with'                  => 'Pagar com',
            'insert-card-details'       => 'Insira os detalhes do cartão',
            'pay-now'                   => 'Pague Agora',
            'cancel'                    => 'Cancelar',
            'invoice-success'           => 'A fatura foi paga.',
            'invoice-failed'            => 'A fatura não foi paga devido a :error',
            'method-unavailable'        => 'Este método de pagamento está inativo, por favor tente outro',
            'invalid-webhook-data'      => 'Dados Webhook inválidos',
            'no-webhook-signature'      => 'Assinatura Webhook não disponível.',
            'no-webhook-secretKey'      => 'Chave secreta Webhook não disponível.',
            'invalid-webhook-signature' => 'Assinatura Webhook inválida.',
            'error-occurred'            => 'Ocorreu um erro ao processar sua solicitação.',
            'error-title'               => 'Erro de Pagamento',
            'back-to-cart'              => 'Voltar ao Carrinho',
            'invoice-pending'           => 'Seu pagamento ainda está sendo processado. Seu pedido será atualizado assim que o MyFatoorah confirmá-lo.',
        ],

        'error'      => [
            'page-title' => 'Erro MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'Nome no Cartão',
                'card-number'            => 'Número',
                'expiry-date'            => 'MM/AA',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'Nome do Titular do Cartão',
                'card-number-label'      => 'Número do Cartão',
                'expiry-date-label'      => 'Data de Validade',
                'security-code-label'    => 'Código de Segurança',
                'save-card'              => 'Salvar número do cartão para pagamentos futuros',
                'add-card'               => 'Usar outro cartão',
                'deleteAlert'            => [
                    'title'   => 'Excluir Cartão',
                    'message' => 'Tem certeza de que deseja remover este cartão?',
                    'confirm' => 'Sim',
                    'cancel'  => 'Não',
                ],
            ],
        ],
    ],
];
