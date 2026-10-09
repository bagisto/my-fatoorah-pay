<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'description-title' => '描述',
                        'logo' => '标志',
                        'description' => '安全的支付模块，支持支付方式，卡数据存储，退款功能和Webhook集成，用于实时状态更新',
                        'api-key' => 'API密钥',
                        'test-mode' => '测试模式',
                        'country-iso' => [
                            'title' => '国家ISO',
                            'kwt' => '科威特',
                            'sau' => '沙特阿拉伯',
                            'qat' => '卡塔尔',
                            'bhr' => '巴林',
                            'omn' => '阿曼',
                            'jod' => '约旦',
                            'egy' => '埃及',
                            'are' => '阿拉伯联合酋长国',
                        ],
                        'is-webhook-enabled' => '启用Webhook',
                        'webhook-secret-key' => 'Webhook密钥',
                        'status' => '状态',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah 无法退款 :amount：:message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - 结账',
            'error-title' => '支付错误',
            'back-to-cart' => '返回购物车',
        ],
    ],

    'response' => [
        'provide-credentials' => '请先配置您的 MyFatoorah API 密钥。',
        'cart-not-found' => '找不到您的购物车。',
        'payment-failed' => '支付未能完成，请重试。',
        'payment-success' => '您的支付已成功！',
    ],
];
