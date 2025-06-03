<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'විස්තරය',
                        'logo'               => 'ලොගෝ',

                        'description'        => 'ගෙවීම් ක්‍රම සහාය, කාඩ් දත්ත ගබඩා කිරීම, ප්‍රතිඥාව කාර්යක්ෂමතා සහ නියම-කාල තත්ත්ව යාවත්කාලීන කිරීම් සඳහා Webhook ඒකාබද්ධ කිරීම සහිත ආරක්ෂිත ගෙවීම් මොඩියුලයක්',
                        'api-key'            => 'API යතුර',
                        'test-mode'          => 'පරීක්ෂණ ක්‍රමය',
                        'country-iso'        => [
                            'title' => 'රටේ ISO',
                            'kwt'   => 'කුවෙයිට්',
                            'sau'   => 'සවුදි අරාබියාව',
                            'qat'   => 'කටාර්',
                            'bhr'   => 'බහරේන්',
                            'omn'   => 'ඔමානය',
                            'jod'   => 'ජෝර්දානය',
                            'egy'   => 'ඊජිප්තුව',
                            'are'   => 'එක්සත් අරාබි එමීර් රාජ්‍යය',
                        ],
                        'is-webhook-enabled' => 'Webhook සක්‍රීය කරන්න',
                        'save-card'          => 'කාඩ් පත සුරකින්න',
                        'webhook-secret-key' => 'Webhook රහස් යතුර',
                        'register-apple-pay' => 'Apple Pay ලියාපදිංචි කරන්න',
                        'status'             => 'තත්ත්වය',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'                => 'MyFatoorah - Checkout',
            'no-payment-gateways'       => 'ඔබගේ ගිණුමේ ගෙවීම් ක්‍රම කිසිවක් ලබා ගත නොහැක, කරුණාකර ඔබේ ගිණුම් කළමනාකරු අමතන්න.',
            'how-would-you-like-to-pay' => 'ඔබට ගෙවීමට කැමති ආකාරය කුමක්ද?',
            'or'                        => 'හෝ',
            'pay-with'                  => 'ගෙවීම',
            'insert-card-details'       => 'කාඩ් පතේ විස්තර ඇතුළු කරන්න',
            'pay-now'                   => 'දැන් ගෙවන්න',
            'invoice-success'           => 'ඉන්වොයිසිය ගෙවා ඇත.',
            'invoice-failed'            => ':error නිසා ඉන්වොයිසිය ගෙවා නොමැත',
            'method-unavailable'        => 'මෙම ගෙවීම් ක්‍රමය අක්‍රීයයි, කරුණාකර වෙනත් ක්‍රමයක් උත්සාහ කරන්න',
            'invalid-webhook-data'      => 'අනීතික Webhook දත්ත',
            'no-webhook-signature'      => 'Webhook අත්සන නොමැත.',
            'no-webhook-secretKey'      => 'Webhook රහස් යතුර නොමැත.',
            'invalid-webhook-signature' => 'අනීතික Webhook අත්සන.',
            'error-occurred'            => 'ඔබේ ඉල්ලීම සැකසීමේදී දෝෂයක් සිදු වී ඇත.',
            'error-title'               => 'ගෙවීම් දෝෂය',
            'back-to-cart'              => 'කරත්තයට ආපසු යන්න',
        ],

        'error' => [
            'page-title' => 'MyFatoorah දෝෂය',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'කාඩ්පතේ නම',
                'card-number'            => 'අංකය',
                'expiry-date'            => 'MM/YY',
                'security-code'          => 'CVV',
                'card-holder-name-label' => 'කාඩ්පතේ නම',
                'card-number-label'      => 'කාඩ් අංකය',
                'expiry-date-label'      => 'කල් ඉකුත්වන දිනය',
                'security-code-label'    => 'ආරක්ෂක කේතය',
                'save-card'              => 'අනාගත ගෙවීම් සඳහා කාඩ්පතේ අංකය සුරකින්න',
                'add-card'               => 'වෙනත් කාඩ්පතක් භාවිතා කරන්න',
                'deleteAlert'            => [
                    'title'    => 'කාඩ්පත ඉවත් කරන්න',
                    'message'  => 'ඔබට මෙම කාඩ්පත ඉවත් කිරීමට අවශ්‍ය බව විශ්වාසද?',
                    'confirm'  => 'ඔව්',
                    'cancel'   => 'නැත',
                ],
            ],
        ],
    ],
];
