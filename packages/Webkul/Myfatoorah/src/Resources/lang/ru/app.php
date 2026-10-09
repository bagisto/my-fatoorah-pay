<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'description-title' => 'Описание',
                        'logo' => 'Логотип',
                        'description' => 'Безопасный модуль оплаты с поддержкой методов оплаты, хранением данных карты, возможностями возврата и интеграцией Webhook для обновлений статуса в реальном времени',
                        'api-key' => 'API ключ',
                        'test-mode' => 'Тестовый режим',
                        'country-iso' => [
                            'title' => 'ISO страны',
                            'kwt' => 'Кувейт',
                            'sau' => 'Саудовская Аравия',
                            'qat' => 'Катар',
                            'bhr' => 'Бахрейн',
                            'omn' => 'Оман',
                            'jod' => 'Иордания',
                            'egy' => 'Египет',
                            'are' => 'Объединенные Арабские Эмираты',
                        ],
                        'is-webhook-enabled' => 'Включить Webhook',
                        'webhook-secret-key' => 'Секретный ключ Webhook',
                        'status' => 'Статус',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah не удалось вернуть :amount: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Оформление заказа',
            'error-title' => 'Ошибка оплаты',
            'back-to-cart' => 'Вернуться в корзину',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Пожалуйста, сначала настройте ваш API-ключ MyFatoorah.',
        'cart-not-found' => 'Ваша корзина не найдена.',
        'payment-failed' => 'Не удалось завершить платеж. Пожалуйста, попробуйте снова.',
        'payment-success' => 'Ваш платеж прошел успешно!',
    ],
];
