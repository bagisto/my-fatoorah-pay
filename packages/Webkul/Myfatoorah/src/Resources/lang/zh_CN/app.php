<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description'        => '安全的支付模块，支持支付方式，卡数据存储，退款功能和Webhook集成，用于实时状态更新',
                        'api-key'            => 'API密钥',
                        'test-mode'          => '测试模式',
                        'currency-iso'       => [
                            'title' => '货币ISO',
                            'kwt'   => '科威特',
                            'sau'   => '沙特阿拉伯',
                            'qat'   => '卡塔尔',
                            'bhr'   => '巴林',
                            'omn'   => '阿曼',
                            'jod'   => '约旦',
                            'egy'   => '埃及',
                            'are'   => '阿拉伯联合酋长国',
                        ],
                        'is-webhook-enabled' => '启用Webhook',
                        'save-card'          => '保存卡',
                        'webhook-secret-key' => 'Webhook密钥',
                        'register-apple-pay' => '注册Apple Pay',
                        'status'             => '状态',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'MyFatoorah - 结账',
            'noPaymentGateways'       => '您的账户上没有可用的支付方式，请联系您的客户经理。',
            'howWouldYouLikeToPay'    => '您想如何支付？',
            'or'                      => '或',
            'payWith'                 => '支付方式',
            'insertCardDetails'       => '输入卡信息',
            'payNow'                  => '立即支付',
            'invoice-success'         => '发票已支付。',
            'invoice-failed'          => '由于 :error，发票未支付',
            'method-unavailable'      => '此支付方式不可用，请尝试其他方式',
            'invalidWebhookData'      => '无效的Webhook数据',
            'noWebhookSignature'      => 'Webhook签名不可用。',
            'noWebhookSecretKey'      => 'Webhook密钥不可用。',
            'invalidWebhookSignature' => '无效的Webhook签名。',
        ],

        'error' => [
            'page-title' => 'MyFatoorah错误',
        ],

        'components' => [
            'form' => [
                'holderName'           => '持卡人姓名',
                'cardNumber'           => '卡号',
                'expiryDate'           => 'MM/YY',
                'securityCode'         => 'CVV',
                'cardHolderNameLabel'  => '持卡人姓名',
                'cardNumberLabel'      => '卡号',
                'expiryDateLabel'      => '有效期',
                'securityCodeLabel'    => '安全码',
                'saveCard'             => '保存卡号以便将来支付',
                'addCard'              => '使用另一张卡',
                'deleteAlert'          => [
                    'title'    => '删除卡片',
                    'message'  => '您确定要删除此卡吗？',
                    'confirm'  => '是',
                    'cancel'   => '否',
                ],
            ],
        ],
    ],
];
