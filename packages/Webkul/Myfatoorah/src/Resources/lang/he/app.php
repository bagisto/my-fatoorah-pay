<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'תיאור',
                        'logo'               => 'לוגו',
                        'description'        => 'מודול תשלום מאובטח עם תמיכה בשיטות תשלום, אחסון נתוני כרטיס, יכולות החזר ושילוב Webhook לעדכוני סטטוס בזמן אמת',
                        'api-key'            => 'מפתח API',
                        'test-mode'          => 'מצב בדיקה',
                        'country-iso'        => [
                            'title' => 'ISO מדינה',
                            'kwt'   => 'כווית',
                            'sau'   => 'ערב הסעודית',
                            'qat'   => 'קטאר',
                            'bhr'   => 'בחריין',
                            'omn'   => 'עומאן',
                            'jod'   => 'ירדן',
                            'egy'   => 'מצרים',
                            'are'   => 'איחוד האמירויות הערביות',
                        ],
                        'is-webhook-enabled' => 'הפעל Webhook',
                        'save-card'          => 'שמור כרטיס',
                        'webhook-secret-key' => 'מפתח סודי של Webhook',
                        'register-apple-pay' => 'רישום Apple Pay',
                        'status'             => 'סטטוס',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'                => 'MyFatoorah - תשלום',
            'no-payment-gateways'       => 'אין שיטות תשלום זמינות בחשבונך, אנא פנה למנהל החשבון שלך.',
            'how-would-you-like-to-pay' => 'כיצד תרצה לשלם?',
            'or'                        => 'או',
            'pay-with'                  => 'שלם עם',
            'insert-card-details'       => 'הזן פרטי כרטיס',
            'pay-now'                   => 'שלם עכשיו',
            'invoice-success'           => 'החשבונית שולמה.',
            'invoice-failed'            => 'החשבונית לא שולמה עקב :error',
            'method-unavailable'        => 'שיטת תשלום זו אינה זמינה, אנא נסה שיטה אחרת',
            'invalid-webhook-data'      => 'נתוני Webhook שגויים',
            'no-webhook-signature'      => 'חתימת Webhook אינה זמינה.',
            'no-webhook-secretKey'      => 'מפתח סודי של Webhook אינו זמין.',
            'invalid-webhook-signature' => 'חתימת Webhook שגויה.',
            'error-occurred'            => 'אירעה שגיאה בעת עיבוד הבקשה שלך.',
        ],

        'error' => [
            'page-title' => 'שגיאת MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holder-name'             => 'שם על הכרטיס',
                'card-number'             => 'מספר כרטיס',
                'expiry-date'             => 'תאריך תפוגה',
                'security-code'           => 'קוד אבטחה',
                'card-holder-name-label'  => 'שם בעל הכרטיס',
                'card-number-label'       => 'מספר כרטיס',
                'expiry-date-label'       => 'תאריך תפוגה',
                'security-code-label'     => 'קוד אבטחה',
                'save-card'               => 'שמור מספר כרטיס לתשלומים עתידיים',
                'add-card'                => 'השתמש בכרטיס אחר',
                'deleteAlert'             => [
                    'title'    => 'מחק כרטיס',
                    'message'  => 'האם אתה בטוח שברצונך למחוק כרטיס זה?',
                    'confirm'  => 'כן',
                    'cancel'   => 'לא',
                ],
            ],
        ],
    ],
];
