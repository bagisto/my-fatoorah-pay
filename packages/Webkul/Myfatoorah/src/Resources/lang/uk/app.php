<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Опис',
                        'logo'               => 'Логотип',
                        'description'        => 'Безпечний платіжний модуль з підтримкою методів оплати, зберіганням даних картки, можливістю повернення коштів та інтеграцією Webhook для оновлень статусу в режимі реального часу',
                        'api-key'            => 'API Ключ',
                        'test-mode'          => 'Тестовий Режим',
                        'country-iso'        => [
                            'title' => 'ISO країни',
                            'kwt'   => 'Кувейт',
                            'sau'   => 'Саудівська Аравія',
                            'qat'   => 'Катар',
                            'bhr'   => 'Бахрейн',
                            'omn'   => 'Оман',
                            'jod'   => 'Йорданія',
                            'egy'   => 'Єгипет',
                            'are'   => 'Об\'єднані Арабські Емірати',
                        ],
                        'is-webhook-enabled' => 'Увімкнути Webhook',
                        'save-card'          => 'Зберегти Картку',
                        'webhook-secret-key' => 'Секретний Ключ Webhook',
                        'register-apple-pay' => 'Зареєструвати Apple Pay',
                        'status'             => 'Статус',
                    ],
                ],
            ],
        ],

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'Прив\'язка Apple Pay',
                'description' => 'Прив\'язка Apple Pay у налаштуваннях MyFatoorah',
                'save-btn'    => 'Зберегти',
                'back-btn'    => 'Назад',
                'url'         => 'URL',
            ],
        ],

        'unexpected-payment' => 'MyFatoorah повідомив про платіж :transaction для цього замовлення, коли його статус був :status. Перевірте платіж у MyFatoorah і поверніть його, якщо він не потрібен.',
        'refund-failed'      => 'MyFatoorah не вдалося повернути :amount: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'MyFatoorah - Оформлення Замовлення',
            'no-payment-gateways'       => 'На вашому обліковому записі немає доступних методів оплати, будь ласка, зв\'яжіться з вашим менеджером облікового запису.',
            'how-would-you-like-to-pay' => 'Як ви хочете заплатити?',
            'or'                        => 'Або',
            'pay-with'                  => 'Оплатити з',
            'insert-card-details'       => 'Введіть Дані Картки',
            'pay-now'                   => 'Оплатити Зараз',
            'cancel'                    => 'Скасувати',
            'invoice-success'           => 'Рахунок оплачений.',
            'invoice-failed'            => 'Рахунок не оплачений через :error',
            'method-unavailable'        => 'Цей метод оплати неактивний, спробуйте інший',
            'invalid-webhook-data'      => 'Недійсні дані Webhook',
            'no-webhook-signature'      => 'Підпис Webhook недоступний.',
            'no-webhook-secretKey'      => 'Секретний ключ Webhook недоступний.',
            'invalid-webhook-signature' => 'Недійсний підпис Webhook.',
            'error-occurred'            => 'Сталася помилка під час обробки вашого запиту.',
            'error-title'               => 'Помилка оплати',
            'back-to-cart'              => 'Повернутися до кошика',
            'invoice-pending'           => 'Ваш платіж ще обробляється. Замовлення буде оновлено, щойно MyFatoorah його підтвердить.',
        ],

        'error'      => [
            'page-title' => 'Помилка MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'Ім\'я на Картці',
                'card-number'            => 'Номер',
                'expiry-date'            => 'MM/YY',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'Ім\'я Власника Картки',
                'card-number-label'      => 'Номер Картки',
                'expiry-date-label'      => 'Дата Закінчення',
                'security-code-label'    => 'Код Безпеки',
                'save-card'              => 'Зберегти номер картки для майбутніх платежів',
                'add-card'               => 'Використовувати іншу картку',
                'deleteAlert'            => [
                    'title'   => 'Видалити Картку',
                    'message' => 'Ви впевнені, що хочете видалити цю картку?',
                    'confirm' => 'Так',
                    'cancel'  => 'Ні',
                ],
            ],
        ],
    ],
];
