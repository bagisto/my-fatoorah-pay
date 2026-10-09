<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'description-title' => 'Deskripsi',
                        'logo' => 'Logo',
                        'description' => 'Modul pembayaran MyFatoorah memungkinkan pembayaran dengan berbagai pilihan seperti Apple Pay, Google Pay, serta kartu kredit dan debit.',
                        'api-key' => 'Kunci API',
                        'test-mode' => 'Mode Uji',
                        'country-iso' => [
                            'title' => 'Negara (ISO)',
                            'kwt' => 'Kuwait',
                            'sau' => 'Arab Saudi',
                            'qat' => 'Qatar',
                            'bhr' => 'Bahrain',
                            'omn' => 'Oman',
                            'jod' => 'Yordania',
                            'egy' => 'Mesir',
                            'are' => 'Uni Emirat Arab',
                        ],
                        'is-webhook-enabled' => 'Aktifkan Webhook',
                        'webhook-secret-key' => 'Kunci Rahasia Webhook',
                        'status' => 'Status',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah tidak dapat mengembalikan :amount: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Pembayaran',
            'error-title' => 'Kesalahan Pembayaran',
            'back-to-cart' => 'Kembali ke Keranjang',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Silakan konfigurasikan kunci API MyFatoorah Anda terlebih dahulu.',
        'cart-not-found' => 'Keranjang Anda tidak ditemukan.',
        'payment-failed' => 'Pembayaran tidak dapat diselesaikan. Silakan coba lagi.',
        'payment-success' => 'Pembayaran Anda berhasil!',
    ],
];
