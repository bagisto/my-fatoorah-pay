<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Описание',
                        'logo'               => 'Логотип',
                        'description'        => 'Безопасный модуль оплаты с поддержкой методов оплаты, хранением данных карты, возможностями возврата и интеграцией Webhook для обновлений статуса в реальном времени',
                        'api-key'            => 'API ключ',
                        'test-mode'          => 'Тестовый режим',
                        'country-iso'        => [
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

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'Привязка Apple Pay',
                'description' => 'Привязка Apple Pay в настройках MyFatoorah',
                'save-btn'    => 'Сохранить',
                'back-btn'    => 'Назад',
                'url'         => 'URL',
            ],
        ],

        'unexpected-payment' => 'MyFatoorah сообщил о платеже :transaction по этому заказу, когда его статус был :status. Проверьте платёж в MyFatoorah и верните его, если он не нужен.',
        'refund-failed'      => 'MyFatoorah не удалось вернуть :amount: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'MyFatoorah - Оформление заказа',
            'no-payment-gateways'       => 'Нет доступных методов оплаты на вашем аккаунте, пожалуйста, свяжитесь с менеджером вашего аккаунта.',
            'how-would-you-like-to-pay' => 'Как вы хотите заплатить?',
            'or'                        => 'Или',
            'pay-with'                  => 'Оплатить с',
            'insert-card-details'       => 'Введите данные карты',
            'pay-now'                   => 'Оплатить сейчас',
            'cancel'                    => 'Отмена',
            'invoice-success'           => 'Счет оплачен.',
            'invoice-failed'            => 'Счет не оплачен из-за :error',
            'method-unavailable'        => 'Этот метод оплаты неактивен, попробуйте другой',
            'invalid-webhook-data'      => 'Недействительные данные Webhook',
            'no-webhook-signature'      => 'Подпись Webhook недоступна.',
            'no-webhook-secretKey'      => 'Секретный ключ Webhook недоступен.',
            'invalid-webhook-signature' => 'Недействительная подпись Webhook.',
            'error-occurred'            => 'Произошла ошибка при обработке вашего запроса.',
            'error-title'               => 'Ошибка оплаты',
            'back-to-cart'              => 'Вернуться в корзину',
            'invoice-pending'           => 'Ваш платёж ещё обрабатывается. Заказ будет обновлён, как только MyFatoorah его подтвердит.',
        ],

        'error'      => [
            'page-title' => 'Ошибка MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'Имя на карте',
                'card-number'            => 'Номер',
                'expiry-date'            => 'ММ/ГГ',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'Имя держателя карты',
                'card-number-label'      => 'Номер карты',
                'expiry-date-label'      => 'Срок действия',
                'security-code-label'    => 'Код безопасности',
                'save-card'              => 'Сохранить номер карты для будущих платежей',
                'add-card'               => 'Использовать другую карту',
                'deleteAlert'            => [
                    'title'   => 'Удалить карту',
                    'message' => 'Вы уверены, что хотите удалить эту карту?',
                    'confirm' => 'Да',
                    'cancel'  => 'Нет',
                ],
            ],
        ],
    ],
];
