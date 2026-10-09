<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'description-title' => 'Açıklama',
                        'logo' => 'Logo',
                        'description' => 'Ödeme yöntemi desteği, kart verisi saklama, geri ödeme yetenekleri ve gerçek zamanlı durum güncellemeleri için Webhook entegrasyonu ile güvenli ödeme modülü',
                        'api-key' => 'API Anahtarı',
                        'test-mode' => 'Test Modu',
                        'country-iso' => [
                            'title' => 'Ülke ISO',
                            'kwt' => 'Kuveyt',
                            'sau' => 'Suudi Arabistan',
                            'qat' => 'Katar',
                            'bhr' => 'Bahreyn',
                            'omn' => 'Umman',
                            'jod' => 'Ürdün',
                            'egy' => 'Mısır',
                            'are' => 'Birleşik Arap Emirlikleri',
                        ],
                        'is-webhook-enabled' => 'Webhook\'u Etkinleştir',
                        'webhook-secret-key' => 'Webhook Gizli Anahtarı',
                        'status' => 'Durum',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah :amount tutarını iade edemedi: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Ödeme',
            'error-title' => 'Ödeme Hatası',
            'back-to-cart' => 'Sepete Geri Dön',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Lütfen önce MyFatoorah API anahtarınızı yapılandırın.',
        'cart-not-found' => 'Sepetiniz bulunamadı.',
        'payment-failed' => 'Ödeme tamamlanamadı. Lütfen tekrar deneyin.',
        'payment-success' => 'Ödemeniz başarılı oldu!',
    ],
];
