<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'payment-title' => 'Назва',
                        'description-title' => 'Опис',
                        'logo' => 'Логотип',
                        'description' => 'Безпечний платіжний модуль з підтримкою методів оплати, зберіганням даних картки, можливістю повернення коштів та інтеграцією Webhook для оновлень статусу в режимі реального часу',
                        'api-key' => 'API Ключ',
                        'test-mode' => 'Тестовий Режим',
                        'country-iso' => [
                            'title' => 'ISO країни',
                            'kwt' => 'Кувейт',
                            'sau' => 'Саудівська Аравія',
                            'qat' => 'Катар',
                            'bhr' => 'Бахрейн',
                            'omn' => 'Оман',
                            'jod' => 'Йорданія',
                            'egy' => 'Єгипет',
                            'are' => 'Об\'єднані Арабські Емірати',
                        ],
                        'is-webhook-enabled' => 'Увімкнути Webhook',
                        'webhook-secret-key' => 'Секретний Ключ Webhook',
                        'status' => 'Статус',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah не вдалося повернути :amount: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Оформлення Замовлення',
            'error-title' => 'Помилка оплати',
            'back-to-cart' => 'Повернутися до кошика',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Будь ласка, спочатку налаштуйте ваш API-ключ MyFatoorah.',
        'cart-not-found' => 'Ваш кошик не знайдено.',
        'payment-failed' => 'Не вдалося завершити оплату. Будь ласка, спробуйте ще раз.',
        'payment-success' => 'Ваш платіж успішно виконано!',
    ],
];
