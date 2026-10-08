<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Açıklama',
                        'logo'               => 'Logo',
                        'description'        => 'Ödeme yöntemi desteği, kart verisi saklama, geri ödeme yetenekleri ve gerçek zamanlı durum güncellemeleri için Webhook entegrasyonu ile güvenli ödeme modülü',
                        'api-key'            => 'API Anahtarı',
                        'test-mode'          => 'Test Modu',
                        'country-iso'        => [
                            'title' => 'Ülke ISO',
                            'kwt'   => 'Kuveyt',
                            'sau'   => 'Suudi Arabistan',
                            'qat'   => 'Katar',
                            'bhr'   => 'Bahreyn',
                            'omn'   => 'Umman',
                            'jod'   => 'Ürdün',
                            'egy'   => 'Mısır',
                            'are'   => 'Birleşik Arap Emirlikleri',
                        ],
                        'is-webhook-enabled' => 'Webhook\'u Etkinleştir',
                        'save-card'          => 'Kartı Kaydet',
                        'webhook-secret-key' => 'Webhook Gizli Anahtarı',
                        'register-apple-pay' => 'Apple Pay\'i Kaydet',
                        'status'             => 'Durum',
                    ],
                ],
            ],
        ],

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'Apple Pay Eşleştir',
                'description' => 'MyFatoorah Ayarlarında Apple Pay Eşleştir',
                'save-btn'    => 'Kaydet',
                'back-btn'    => 'Geri',
                'url'         => 'URL',
            ],
        ],

        'unexpected-payment' => 'MyFatoorah, bu sipariş :status durumundayken :transaction ödemesini bildirdi. Ödemeyi MyFatoorah üzerinden kontrol edin ve gerekli değilse iade edin.',
        'refund-failed'      => 'MyFatoorah :amount tutarını iade edemedi: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'MyFatoorah - Ödeme',
            'no-payment-gateways'       => 'Hesabınızda mevcut ödeme yöntemleri yok, lütfen hesap yöneticinizle iletişime geçin.',
            'how-would-you-like-to-pay' => 'Nasıl ödemek istersiniz?',
            'or'                        => 'Veya',
            'pay-with'                  => 'Şununla Ödeyin',
            'insert-card-details'       => 'Kart Bilgilerini Girin',
            'pay-now'                   => 'Şimdi Ödeyin',
            'cancel'                    => 'İptal',
            'invoice-success'           => 'Fatura ödendi.',
            'invoice-failed'            => ':error nedeniyle fatura ödenmedi',
            'method-unavailable'        => 'Bu Ödeme Yöntemi Etkin Değil, lütfen başka birini deneyin',
            'invalid-webhook-data'      => 'Geçersiz Webhook Verisi',
            'no-webhook-signature'      => 'Webhook İmzası mevcut değil.',
            'no-webhook-secretKey'      => 'Webhook Gizli Anahtarı mevcut değil.',
            'invalid-webhook-signature' => 'Geçersiz Webhook İmzası.',
            'error-occurred'            => 'İsteğiniz işlenirken bir hata oluştu.',
            'error-title'               => 'Ödeme Hatası',
            'back-to-cart'              => 'Sepete Geri Dön',
            'invoice-pending'           => 'Ödemeniz hâlâ işleniyor. MyFatoorah onayladığı anda siparişiniz güncellenecek.',
        ],

        'error'      => [
            'page-title' => 'MyFatoorah Hatası',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'Karttaki İsim',
                'card-number'            => 'Numara',
                'expiry-date'            => 'AA/YY',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'Kart Sahibi İsmi',
                'card-number-label'      => 'Kart Numarası',
                'expiry-date-label'      => 'Son Kullanma Tarihi',
                'security-code-label'    => 'Güvenlik Kodu',
                'save-card'              => 'Gelecek ödemeler için kart numarasını kaydedin',
                'add-card'               => 'Başka bir kart kullanın',
                'deleteAlert'            => [
                    'title'   => 'Kartı Sil',
                    'message' => 'Bu kartı kaldırmak istediğinizden emin misiniz?',
                    'confirm' => 'Evet',
                    'cancel'  => 'Hayır',
                ],
            ],
        ],
    ],
];
