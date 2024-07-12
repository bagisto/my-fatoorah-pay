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
                        'currency-iso'       => [
                            'title' => 'ISO waluty',
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
            'page-title'              => 'MyFatoorah - Płatność',
            'noPaymentGateways'       => 'Brak dostępnych metod płatności na twoim koncie, skontaktuj się z menedżerem konta.',
            'howWouldYouLikeToPay'    => 'Jak chcesz zapłacić?',
            'or'                      => 'Lub',
            'payWith'                 => 'Zapłać z',
            'insertCardDetails'       => 'Wprowadź dane karty',
            'payNow'                  => 'Zapłać teraz',
            'invoice-success'         => 'Faktura została opłacona.',
            'invoice-failed'          => 'Faktura nie została opłacona z powodu :error',
            'method-unavailable'      => 'Ta metoda płatności jest nieaktywna, spróbuj inną',
            'invalidWebhookData'      => 'Nieprawidłowe dane Webhook',
            'noWebhookSignature'      => 'Brak podpisu Webhook.',
            'noWebhookSecretKey'      => 'Brak tajnego klucza Webhook.',
            'invalidWebhookSignature' => 'Nieprawidłowy podpis Webhook.',
            'error-occurred'          => 'Wystąpił błąd podczas przetwarzania Twojego żądania.',
        ],

        'error' => [
            'page-title' => 'Błąd MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'Imię na karcie',
                'cardNumber'           => 'Numer',
                'expiryDate'           => 'MM/RR',
                'securityCode'         => 'CVV',
                'cardHolderNameLabel'  => 'Imię posiadacza karty',
                'cardNumberLabel'      => 'Numer karty',
                'expiryDateLabel'      => 'Data wygaśnięcia',
                'securityCodeLabel'    => 'Kod bezpieczeństwa',
                'saveCard'             => 'Zapisz numer karty na przyszłe płatności',
                'addCard'              => 'Użyj innej karty',
                'deleteAlert'          => [
                    'title'    => 'Usuń kartę',
                    'message'  => 'Czy na pewno chcesz usunąć tę kartę?',
                    'confirm'  => 'Tak',
                    'cancel'   => 'Nie',
                ],
            ],
        ],
    ],
];
