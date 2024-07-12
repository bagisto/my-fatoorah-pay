<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Описание',
                        'logo'               => 'Логотип',
                        'description'        => 'Безопасный модуль оплаты с поддержкой методов оплаты, хранением данных карты, возможностями возврата и интеграцией Webhook для обновлений статуса в реальном времени',
                        'api-key'            => 'API ключ',
                        'test-mode'          => 'Тестовый режим',
                        'country-iso'       => [
                            'title' => 'ISO страны',
                            'kwt'   => 'Кувейт',
                            'sau'   => 'Саудовская Аравия',
                            'qat'   => 'Катар',
                            'bhr'   => 'Бахрейн',
                            'omn'   => 'Оман',
                            'jod'   => 'Иордания',
                            'egy'   => 'Египет',
                            'are'   => 'Объединенные Арабские Эмираты',
                        ],
                        'is-webhook-enabled' => 'Включить Webhook',
                        'save-card'          => 'Сохранить карту',
                        'webhook-secret-key' => 'Секретный ключ Webhook',
                        'register-apple-pay' => 'Зарегистрировать Apple Pay',
                        'status'             => 'Статус',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'MyFatoorah - Оформление заказа',
            'noPaymentGateways'       => 'Нет доступных методов оплаты на вашем аккаунте, пожалуйста, свяжитесь с менеджером вашего аккаунта.',
            'howWouldYouLikeToPay'    => 'Как вы хотите заплатить?',
            'or'                      => 'Или',
            'payWith'                 => 'Оплатить с',
            'insertCardDetails'       => 'Введите данные карты',
            'payNow'                  => 'Оплатить сейчас',
            'invoice-success'         => 'Счет оплачен.',
            'invoice-failed'          => 'Счет не оплачен из-за :error',
            'method-unavailable'      => 'Этот метод оплаты неактивен, попробуйте другой',
            'invalidWebhookData'      => 'Недействительные данные Webhook',
            'noWebhookSignature'      => 'Подпись Webhook недоступна.',
            'noWebhookSecretKey'      => 'Секретный ключ Webhook недоступен.',
            'invalidWebhookSignature' => 'Недействительная подпись Webhook.',
            'error-occurred'          => 'Произошла ошибка при обработке вашего запроса.',
        ],

        'error' => [
            'page-title' => 'Ошибка MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'Имя на карте',
                'cardNumber'           => 'Номер',
                'expiryDate'           => 'ММ/ГГ',
                'securityCode'         => 'CVV',
                'cardHolderNameLabel'  => 'Имя держателя карты',
                'cardNumberLabel'      => 'Номер карты',
                'expiryDateLabel'      => 'Срок действия',
                'securityCodeLabel'    => 'Код безопасности',
                'saveCard'             => 'Сохранить номер карты для будущих платежей',
                'addCard'              => 'Использовать другую карту',
                'deleteAlert'          => [
                    'title'    => 'Удалить карту',
                    'message'  => 'Вы уверены, что хотите удалить эту карту?',
                    'confirm'  => 'Да',
                    'cancel'   => 'Нет',
                ],
            ],
        ],
    ],
];
