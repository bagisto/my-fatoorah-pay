<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'payment-title' => 'Tytuł',
                        'description-title' => 'Opis',
                        'logo' => 'Logo',
                        'description' => 'Bezpieczny moduł płatności z obsługą metod płatności, przechowywaniem danych karty, możliwością zwrotów oraz integracją Webhook do aktualizacji statusu w czasie rzeczywistym',
                        'api-key' => 'Klucz API',
                        'test-mode' => 'Tryb testowy',
                        'country-iso' => [
                            'title' => 'ISO do país',
                            'kwt' => 'Kuwejt',
                            'sau' => 'Arabia Saudyjska',
                            'qat' => 'Katar',
                            'bhr' => 'Bahrajn',
                            'omn' => 'Oman',
                            'jod' => 'Jordania',
                            'egy' => 'Egipt',
                            'are' => 'Zjednoczone Emiraty Arabskie',
                        ],
                        'is-webhook-enabled' => 'Włącz Webhook',
                        'webhook-secret-key' => 'Tajny klucz Webhook',
                        'status' => 'Status',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah nie mógł zwrócić kwoty :amount: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Płatność',
            'error-title' => 'Błąd Płatności',
            'back-to-cart' => 'Powrót do Koszyka',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Najpierw skonfiguruj swój klucz API MyFatoorah.',
        'cart-not-found' => 'Nie znaleziono Twojego koszyka.',
        'payment-failed' => 'Nie można zrealizować płatności. Spróbuj ponownie.',
        'payment-success' => 'Twoja płatność zakończyła się sukcesem!',
    ],
];
