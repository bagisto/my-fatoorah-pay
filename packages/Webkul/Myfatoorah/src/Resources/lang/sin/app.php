<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'description-title' => 'විස්තරය',
                        'logo' => 'ලොගෝ',
                        'description' => 'ගෙවීම් ක්‍රම සහාය, කාඩ් දත්ත ගබඩා කිරීම, ප්‍රතිඥාව කාර්යක්ෂමතා සහ නියම-කාල තත්ත්ව යාවත්කාලීන කිරීම් සඳහා Webhook ඒකාබද්ධ කිරීම සහිත ආරක්ෂිත ගෙවීම් මොඩියුලයක්',
                        'api-key' => 'API යතුර',
                        'test-mode' => 'පරීක්ෂණ ක්‍රමය',
                        'country-iso' => [
                            'title' => 'රටේ ISO',
                            'kwt' => 'කුවෙයිට්',
                            'sau' => 'සවුදි අරාබියාව',
                            'qat' => 'කටාර්',
                            'bhr' => 'බහරේන්',
                            'omn' => 'ඔමානය',
                            'jod' => 'ජෝර්දානය',
                            'egy' => 'ඊජිප්තුව',
                            'are' => 'එක්සත් අරාබි එමීර් රාජ්‍යය',
                        ],
                        'is-webhook-enabled' => 'Webhook සක්‍රීය කරන්න',
                        'webhook-secret-key' => 'Webhook රහස් යතුර',
                        'status' => 'තත්ත්වය',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah හට :amount ආපසු ගෙවීමට නොහැකි විය: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Checkout',
            'error-title' => 'ගෙවීම් දෝෂය',
            'back-to-cart' => 'කරත්තයට ආපසු යන්න',
        ],
    ],

    'response' => [
        'provide-credentials' => 'කරුණාකර පළමුව ඔබගේ MyFatoorah API යතුර සකසන්න.',
        'cart-not-found' => 'ඔබගේ කරත්තය සොයාගත නොහැකි විය.',
        'payment-failed' => 'ගෙවීම සම්පූර්ණ කළ නොහැකි විය. කරුණාකර නැවත උත්සාහ කරන්න.',
        'payment-success' => 'ඔබගේ ගෙවීම සාර්ථකයි!',
    ],
];
