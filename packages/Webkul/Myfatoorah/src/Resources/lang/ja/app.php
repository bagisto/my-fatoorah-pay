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
                        'country-iso'       => [
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
            'page-title'              => 'MyFatoorah - チェックアウト',
            'noPaymentGateways'       => 'アカウントに利用可能な支払い方法がありません。アカウントマネージャーに連絡してください。',
            'howWouldYouLikeToPay'    => 'どのように支払いますか？',
            'or'                      => 'または',
            'payWith'                 => '支払い方法',
            'insertCardDetails'       => 'カードの詳細を入力',
            'payNow'                  => '今すぐ支払う',
            'invoice-success'         => '請求書が支払われました。',
            'invoice-failed'          => ':error のため、請求書は支払われませんでした',
            'method-unavailable'      => 'この支払い方法は無効です。他の方法を試してください',
            'invalidWebhookData'      => '無効なWebhookデータ',
            'noWebhookSignature'      => 'Webhook署名がありません。',
            'noWebhookSecretKey'      => 'Webhookシークレットキーがありません。',
            'invalidWebhookSignature' => '無効なWebhook署名。',
            'error-occurred'          => 'リクエストの処理中にエラーが発生しました。',
        ],

        'error' => [
            'page-title' => 'MyFatoorahエラー',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'カード上の名前',
                'cardNumber'           => '番号',
                'expiryDate'           => '有効期限',
                'securityCode'         => 'CVV',
                'cardHolderNameLabel'  => 'カードホルダー名',
                'cardNumberLabel'      => 'カード番号',
                'expiryDateLabel'      => '有効期限',
                'securityCodeLabel'    => 'セキュリティコード',
                'saveCard'             => '今後の支払いのためにカード番号を保存する',
                'addCard'              => '別のカードを使用',
                'deleteAlert'          => [
                    'title'    => 'カードを削除',
                    'message'  => 'このカードを削除してもよろしいですか？',
                    'confirm'  => 'はい',
                    'cancel'   => 'いいえ',
                ],
            ],
        ],
    ],
];
