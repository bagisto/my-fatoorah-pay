<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'description-title' => 'תיאור',
                        'logo' => 'לוגו',
                        'description' => 'מודול תשלום מאובטח עם תמיכה בשיטות תשלום, אחסון נתוני כרטיס, יכולות החזר ושילוב Webhook לעדכוני סטטוס בזמן אמת',
                        'api-key' => 'מפתח API',
                        'test-mode' => 'מצב בדיקה',
                        'country-iso' => [
                            'title' => 'ISO מדינה',
                            'kwt' => 'כווית',
                            'sau' => 'ערב הסעודית',
                            'qat' => 'קטאר',
                            'bhr' => 'בחריין',
                            'omn' => 'עומאן',
                            'jod' => 'ירדן',
                            'egy' => 'מצרים',
                            'are' => 'איחוד האמירויות הערביות',
                        ],
                        'is-webhook-enabled' => 'הפעל Webhook',
                        'webhook-secret-key' => 'מפתח סודי של Webhook',
                        'status' => 'סטטוס',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah לא הצליחה להחזיר :amount: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - תשלום',
            'error-title' => 'שגיאת תשלום',
            'back-to-cart' => 'חזרה לעגלת קניות',
        ],
    ],

    'response' => [
        'provide-credentials' => 'אנא הגדר תחילה את מפתח ה-API של MyFatoorah.',
        'cart-not-found' => 'לא ניתן למצוא את העגלה שלך.',
        'payment-failed' => 'לא ניתן היה להשלים את התשלום. אנא נסה שוב.',
        'payment-success' => 'התשלום שלך בוצע בהצלחה!',
    ],
];
