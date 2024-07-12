<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description'        => 'Безпечний платіжний модуль з підтримкою методів оплати, зберіганням даних картки, можливістю повернення коштів та інтеграцією Webhook для оновлень статусу в режимі реального часу',
                        'api-key'            => 'API Ключ',
                        'test-mode'          => 'Тестовий Режим',
                        'currency-iso'       => [
                            'title' => 'Валюта ISO',
                            'kwt'   => 'Кувейт',
                            'sau'   => 'Саудівська Аравія',
                            'qat'   => 'Катар',
                            'bhr'   => 'Бахрейн',
                            'omn'   => 'Оман',
                            'jod'   => 'Йорданія',
                            'egy'   => 'Єгипет',
                            'are'   => 'Об’єднані Арабські Емірати',
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
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'MyFatoorah - Оформлення Замовлення',
            'noPaymentGateways'       => 'На вашому обліковому записі немає доступних методів оплати, будь ласка, зв’яжіться з вашим менеджером облікового запису.',
            'howWouldYouLikeToPay'    => 'Як ви хочете заплатити?',
            'or'                      => 'Або',
            'payWith'                 => 'Оплатити з',
            'insertCardDetails'       => 'Введіть Дані Картки',
            'payNow'                  => 'Оплатити Зараз',
            'invoice-success'         => 'Рахунок оплачений.',
            'invoice-failed'          => 'Рахунок не оплачений через :error',
            'method-unavailable'      => 'Цей метод оплати неактивний, спробуйте інший',
            'invalidWebhookData'      => 'Недійсні дані Webhook',
            'noWebhookSignature'      => 'Підпис Webhook недоступний.',
            'noWebhookSecretKey'      => 'Секретний ключ Webhook недоступний.',
            'invalidWebhookSignature' => 'Недійсний підпис Webhook.',
        ],

        'error' => [
            'page-title' => 'Помилка MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'Ім’я на Картці',
                'cardNumber'           => 'Номер',
                'expiryDate'           => 'MM/YY',
                'securityCode'         => 'CVV',
                'cardHolderNameLabel'  => 'Ім’я Власника Картки',
                'cardNumberLabel'      => 'Номер Картки',
                'expiryDateLabel'      => 'Дата Закінчення',
                'securityCodeLabel'    => 'Код Безпеки',
                'saveCard'             => 'Зберегти номер картки для майбутніх платежів',
                'addCard'              => 'Використовувати іншу картку',
                'deleteAlert'          => [
                    'title'    => 'Видалити Картку',
                    'message'  => 'Ви впевнені, що хочете видалити цю картку?',
                    'confirm'  => 'Так',
                    'cancel'   => 'Ні',
                ],
            ],
        ],
    ],
];
