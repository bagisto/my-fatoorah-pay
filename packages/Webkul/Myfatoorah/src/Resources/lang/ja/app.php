<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => '説明',
                        'logo'               => 'ロゴ',
                        'description'        => '支払い方法のサポート、カードデータの保存、返金機能、リアルタイムのステータス更新のためのWebhook統合を備えた安全な支払いモジュール',
                        'api-key'            => 'APIキー',
                        'test-mode'          => 'テストモード',
                        'country-iso'        => [
                            'title' => '国ISO',
                            'kwt'   => 'クウェート',
                            'sau'   => 'サウジアラビア',
                            'qat'   => 'カタール',
                            'bhr'   => 'バーレーン',
                            'omn'   => 'オマーン',
                            'jod'   => 'ヨルダン',
                            'egy'   => 'エジプト',
                            'are'   => 'アラブ首長国連邦',
                        ],
                        'is-webhook-enabled' => 'Webhookを有効にする',
                        'save-card'          => 'カードを保存する',
                        'webhook-secret-key' => 'Webhookシークレットキー',
                        'register-apple-pay' => 'Apple Payを登録する',
                        'status'             => 'ステータス',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'                => 'MyFatoorah - チェックアウト',
            'no-payment-gateways'       => 'アカウントに利用可能な支払い方法がありません。アカウントマネージャーに連絡してください。',
            'how-would-you-like-to-pay' => 'どのように支払いますか？',
            'or'                        => 'または',
            'pay-with'                  => '支払い方法',
            'insert-card-details'       => 'カードの詳細を入力',
            'pay-now'                   => '今すぐ支払う',
            'invoice-success'           => '請求書が支払われました。',
            'invoice-failed'            => ':error のため、請求書は支払われませんでした',
            'method-unavailable'        => 'この支払い方法は無効です。他の方法を試してください',
            'invalid-webhook-data'      => '無効なWebhookデータ',
            'no-webhook-signature'      => 'Webhook署名がありません。',
            'no-webhook-secretKey'      => 'Webhookシークレットキーがありません。',
            'invalid-webhook-signature' => '無効なWebhook署名。',
            'error-occurred'            => 'リクエストの処理中にエラーが発生しました。',
        ],

        'error' => [
            'page-title' => 'MyFatoorahエラー',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'カード上の名前',
                'card-number'            => '番号',
                'expiry-date'            => '有効期限',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'カードホルダー名',
                'card-number-label'      => 'カード番号',
                'expiry-date-label'      => '有効期限',
                'security-code-label'    => 'セキュリティコード',
                'save-card'              => '今後の支払いのためにカード番号を保存する',
                'add-card'               => '別のカードを使用',
                'deleteAlert'            => [
                    'title'    => 'カードを削除',
                    'message'  => 'このカードを削除してもよろしいですか？',
                    'confirm'  => 'はい',
                    'cancel'   => 'いいえ',
                ],
            ],
        ],
    ],
];
