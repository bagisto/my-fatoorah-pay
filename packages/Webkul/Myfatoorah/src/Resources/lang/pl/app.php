<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Opis',
                        'logo'               => 'Logo',
                        'description'        => 'Bezpieczny moduł płatności z obsługą metod płatności, przechowywaniem danych karty, możliwością zwrotów oraz integracją Webhook do aktualizacji statusu w czasie rzeczywistym',
                        'api-key'            => 'Klucz API',
                        'test-mode'          => 'Tryb testowy',
                        'country-iso'        => [
                            'title' => 'ISO do país',
                            'kwt'   => 'Kuwejt',
                            'sau'   => 'Arabia Saudyjska',
                            'qat'   => 'Katar',
                            'bhr'   => 'Bahrajn',
                            'omn'   => 'Oman',
                            'jod'   => 'Jordania',
                            'egy'   => 'Egipt',
                            'are'   => 'Zjednoczone Emiraty Arabskie',
                        ],
                        'is-webhook-enabled' => 'Włącz Webhook',
                        'save-card'          => 'Zapisz kartę',
                        'webhook-secret-key' => 'Tajny klucz Webhook',
                        'register-apple-pay' => 'Zarejestruj Apple Pay',
                        'status'             => 'Status',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'                => 'MyFatoorah - Płatność',
            'no-payment-gateways'       => 'Brak dostępnych metod płatności na twoim koncie, skontaktuj się z menedżerem konta.',
            'how-would-you-like-to-pay' => 'Jak chcesz zapłacić?',
            'or'                        => 'Lub',
            'pay-with'                  => 'Zapłać z',
            'insert-card-details'       => 'Wprowadź dane karty',
            'pay-now'                   => 'Zapłać teraz',
            'invoice-success'           => 'Faktura została opłacona.',
            'invoice-failed'            => 'Faktura nie została opłacona z powodu :error',
            'method-unavailable'        => 'Ta metoda płatności jest nieaktywna, spróbuj inną',
            'invalid-webhook-data'      => 'Nieprawidłowe dane Webhook',
            'no-webhook-signature'      => 'Brak podpisu Webhook.',
            'no-webhook-secretKey'      => 'Brak tajnego klucza Webhook.',
            'invalid-webhook-signature' => 'Nieprawidłowy podpis Webhook.',
            'error-occurred'            => 'Wystąpił błąd podczas przetwarzania Twojego żądania.',
            'error-title'               => 'Błąd Płatności',
            'back-to-cart'              => 'Powrót do Koszyka',
        ],

        'error' => [
            'page-title' => 'Błąd MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'Imię na karcie',
                'card-number'            => 'Numer',
                'expiry-date'            => 'MM/RR',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'Imię posiadacza karty',
                'card-number-label'      => 'Numer karty',
                'expiry-date-label'      => 'Data wygaśnięcia',
                'security-code-label'    => 'Kod bezpieczeństwa',
                'save-card'              => 'Zapisz numer karty na przyszłe płatności',
                'add-card'               => 'Użyj innej karty',
                'deleteAlert'            => [
                    'title'    => 'Usuń kartę',
                    'message'  => 'Czy na pewno chcesz usunąć tę kartę?',
                    'confirm'  => 'Tak',
                    'cancel'   => 'Nie',
                ],
            ],
        ],
    ],
];
