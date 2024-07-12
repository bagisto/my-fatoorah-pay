<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Açıklama',
                        'logo'               => 'Logo',
                        'description'        => 'Ödeme yöntemi desteği, kart verisi saklama, geri ödeme yetenekleri ve gerçek zamanlı durum güncellemeleri için Webhook entegrasyonu ile güvenli ödeme modülü',
                        'api-key'            => 'API Anahtarı',
                        'test-mode'          => 'Test Modu',
                        'country-iso'       => [
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
                        'is-webhook-enabled' => 'Webhook’u Etkinleştir',
                        'save-card'          => 'Kartı Kaydet',
                        'webhook-secret-key' => 'Webhook Gizli Anahtarı',
                        'register-apple-pay' => 'Apple Pay’i Kaydet',
                        'status'             => 'Durum',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'MyFatoorah - Ödeme',
            'noPaymentGateways'       => 'Hesabınızda mevcut ödeme yöntemleri yok, lütfen hesap yöneticinizle iletişime geçin.',
            'howWouldYouLikeToPay'    => 'Nasıl ödemek istersiniz?',
            'or'                      => 'Veya',
            'payWith'                 => 'Şununla Ödeyin',
            'insertCardDetails'       => 'Kart Bilgilerini Girin',
            'payNow'                  => 'Şimdi Ödeyin',
            'invoice-success'         => 'Fatura ödendi.',
            'invoice-failed'          => ':error nedeniyle fatura ödenmedi',
            'method-unavailable'      => 'Bu Ödeme Yöntemi Etkin Değil, lütfen başka birini deneyin',
            'invalidWebhookData'      => 'Geçersiz Webhook Verisi',
            'noWebhookSignature'      => 'Webhook İmzası mevcut değil.',
            'noWebhookSecretKey'      => 'Webhook Gizli Anahtarı mevcut değil.',
            'invalidWebhookSignature' => 'Geçersiz Webhook İmzası.',
            'error-occurred'          => 'İsteğiniz işlenirken bir hata oluştu.',
        ],

        'error' => [
            'page-title' => 'MyFatoorah Hatası',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'Karttaki İsim',
                'cardNumber'           => 'Numara',
                'expiryDate'           => 'AA/YY',
                'securityCode'         => 'CVV',
                'cardHolderNameLabel'  => 'Kart Sahibi İsmi',
                'cardNumberLabel'      => 'Kart Numarası',
                'expiryDateLabel'      => 'Son Kullanma Tarihi',
                'securityCodeLabel'    => 'Güvenlik Kodu',
                'saveCard'             => 'Gelecek ödemeler için kart numarasını kaydedin',
                'addCard'              => 'Başka bir kart kullanın',
                'deleteAlert'          => [
                    'title'    => 'Kartı Sil',
                    'message'  => 'Bu kartı kaldırmak istediğinizden emin misiniz?',
                    'confirm'  => 'Evet',
                    'cancel'   => 'Hayır',
                ],
            ],
        ],
    ],
];
