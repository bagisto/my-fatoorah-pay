<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'payment-title' => 'タイトル',
                        'description-title' => '説明',
                        'logo' => 'ロゴ',
                        'description' => '支払い方法のサポート、カードデータの保存、返金機能、リアルタイムのステータス更新のためのWebhook統合を備えた安全な支払いモジュール',
                        'api-key' => 'APIキー',
                        'test-mode' => 'テストモード',
                        'country-iso' => [
                            'title' => '国ISO',
                            'kwt' => 'クウェート',
                            'sau' => 'サウジアラビア',
                            'qat' => 'カタール',
                            'bhr' => 'バーレーン',
                            'omn' => 'オマーン',
                            'jod' => 'ヨルダン',
                            'egy' => 'エジプト',
                            'are' => 'アラブ首長国連邦',
                        ],
                        'is-webhook-enabled' => 'Webhookを有効にする',
                        'webhook-secret-key' => 'Webhookシークレットキー',
                        'status' => 'ステータス',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah で :amount を返金できませんでした: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - チェックアウト',
            'error-title' => '支払いエラー',
            'back-to-cart' => 'カートに戻る',
        ],
    ],

    'response' => [
        'provide-credentials' => 'まずMyFatoorahのAPIキーを設定してください。',
        'cart-not-found' => 'カートが見つかりませんでした。',
        'payment-failed' => 'お支払いを完了できませんでした。もう一度お試しください。',
        'payment-success' => 'お支払いが完了しました！',
    ],
];
