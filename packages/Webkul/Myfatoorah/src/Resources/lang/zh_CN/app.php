<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => '描述',
                        'logo'               => '标志',
                        'description'        => '安全的支付模块，支持支付方式，卡数据存储，退款功能和Webhook集成，用于实时状态更新',
                        'api-key'            => 'API密钥',
                        'test-mode'          => '测试模式',
                        'country-iso'        => [
                            'title' => '国家ISO',
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

        'settings'           => [
            'map-apple-pay' => [
                'title'       => '关联 Apple Pay',
                'description' => '在 MyFatoorah 设置中关联 Apple Pay',
                'save-btn'    => '保存',
                'back-btn'    => '返回',
                'url'         => '网址',
            ],
        ],

        'unexpected-payment' => '该订单状态为 :status 时，MyFatoorah 报告了付款 :transaction。请在 MyFatoorah 中核实该付款，如不需要请退款。',
        'refund-failed'      => 'MyFatoorah 无法退款 :amount：:message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'MyFatoorah - 结账',
            'no-payment-gateways'       => '您的账户上没有可用的支付方式，请联系您的客户经理。',
            'how-would-you-like-to-pay' => '您想如何支付？',
            'or'                        => '或',
            'pay-with'                  => '支付方式',
            'insert-card-details'       => '输入卡信息',
            'pay-now'                   => '立即支付',
            'cancel'                    => '取消',
            'invoice-success'           => '发票已支付。',
            'invoice-failed'            => '由于 :error，发票未支付',
            'method-unavailable'        => '此支付方式不可用，请尝试其他方式',
            'invalid-webhook-data'      => '无效的Webhook数据',
            'no-webhook-signature'      => 'Webhook签名不可用。',
            'no-webhook-secretKey'      => 'Webhook密钥不可用。',
            'invalid-webhook-signature' => '无效的Webhook签名。',
            'error-occurred'            => '处理您的请求时发生错误。',
            'error-title'               => '支付错误',
            'back-to-cart'              => '返回购物车',
            'invoice-pending'           => '您的付款仍在处理中。MyFatoorah 确认后，您的订单将立即更新。',
        ],

        'error'      => [
            'page-title' => 'MyFatoorah错误',
        ],

        'components' => [
            'form' => [
                'holder-name'            => '持卡人姓名',
                'card-number'            => '卡号',
                'expiry-date'            => 'MM/YY',
                'security-code'          => 'CVV',
                'card-holder-name-label' => '持卡人姓名',
                'card-number-label'      => '卡号',
                'expiry-date-label'      => '有效期',
                'security-code-label'    => '安全码',
                'save-card'              => '保存卡号以便将来支付',
                'add-card'               => '使用另一张卡',
                'deleteAlert'            => [
                    'title'   => '删除卡片',
                    'message' => '您确定要删除此卡吗？',
                    'confirm' => '是',
                    'cancel'  => '否',
                ],
            ],
        ],
    ],
];
