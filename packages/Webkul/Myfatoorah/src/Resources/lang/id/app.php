<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Deskripsi',
                        'logo'               => 'Logo',
                        'description'        => 'Modul pembayaran MyFatoorah memungkinkan pembayaran dengan berbagai pilihan seperti Apple Pay, Google Pay, serta kartu kredit dan debit.',
                        'api-key'            => 'Kunci API',
                        'test-mode'          => 'Mode Uji',
                        'country-iso'        => [
                            'title' => 'Negara (ISO)',
                            'kwt'   => 'Kuwait',
                            'sau'   => 'Arab Saudi',
                            'qat'   => 'Qatar',
                            'bhr'   => 'Bahrain',
                            'omn'   => 'Oman',
                            'jod'   => 'Yordania',
                            'egy'   => 'Mesir',
                            'are'   => 'Uni Emirat Arab',
                        ],
                        'is-webhook-enabled' => 'Aktifkan Webhook',
                        'save-card'          => 'Simpan Kartu',
                        'webhook-secret-key' => 'Kunci Rahasia Webhook',
                        'register-apple-pay' => 'Daftarkan Apple Pay',
                        'status'             => 'Status',
                    ],
                ],
            ],
        ],

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'Hubungkan Apple Pay',
                'description' => 'Hubungkan Apple Pay di Pengaturan MyFatoorah',
                'save-btn'    => 'Simpan',
                'back-btn'    => 'Kembali',
                'url'         => 'URL',
            ],
        ],

        'unexpected-payment' => 'MyFatoorah melaporkan pembayaran :transaction untuk pesanan ini saat statusnya :status. Periksa pembayaran di MyFatoorah dan kembalikan dananya jika tidak diperlukan.',
        'refund-failed'      => 'MyFatoorah tidak dapat mengembalikan :amount: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'MyFatoorah - Pembayaran',
            'no-payment-gateways'       => 'Tidak ada metode pembayaran yang tersedia di akun Anda, silakan hubungi manajer akun Anda.',
            'how-would-you-like-to-pay' => 'Bagaimana Anda ingin membayar?',
            'or'                        => 'Atau',
            'pay-with'                  => 'Bayar Dengan',
            'insert-card-details'       => 'Masukkan Detail Kartu',
            'pay-now'                   => 'Bayar Sekarang',
            'cancel'                    => 'Batal',
            'invoice-success'           => 'Tagihan telah dibayar.',
            'invoice-failed'            => 'Tagihan tidak dibayar karena :error',
            'method-unavailable'        => 'Metode pembayaran ini tidak aktif, silakan coba metode lain',
            'invalid-webhook-data'      => 'Data Webhook Tidak Valid',
            'no-webhook-signature'      => 'Tanda tangan webhook tidak tersedia.',
            'no-webhook-secretKey'      => 'Kunci rahasia webhook tidak tersedia.',
            'invalid-webhook-signature' => 'Tanda tangan webhook tidak valid.',
            'error-occurred'            => 'Terjadi kesalahan saat memproses permintaan Anda.',
            'error-title'               => 'Kesalahan Pembayaran',
            'back-to-cart'              => 'Kembali ke Keranjang',
            'invoice-pending'           => 'Pembayaran Anda masih diproses. Pesanan Anda akan diperbarui segera setelah MyFatoorah mengonfirmasinya.',
        ],

        'error'      => [
            'page-title' => 'Kesalahan MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'Nama pada Kartu',
                'card-number'            => 'Nomor',
                'expiry-date'            => 'BB/TT',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'Nama Pemegang Kartu',
                'card-number-label'      => 'Nomor Kartu',
                'expiry-date-label'      => 'Tanggal Kedaluwarsa',
                'security-code-label'    => 'Kode Keamanan',
                'save-card'              => 'Simpan nomor kartu untuk pembayaran berikutnya',
                'add-card'               => 'Gunakan kartu lain',
                'deleteAlert'            => [
                    'title'   => 'Hapus Kartu',
                    'message' => 'Apakah Anda yakin ingin menghapus kartu ini?',
                    'confirm' => 'Ya',
                    'cancel'  => 'Tidak',
                ],
            ],
        ],
    ],
];
