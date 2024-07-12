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
                        'currency-iso'       => [
                            'title' => 'קוד מטבע ISO',
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
            'page-title'              => 'MyFatoorah - תשלום',
            'noPaymentGateways'       => 'אין שיטות תשלום זמינות בחשבונך, אנא פנה למנהל החשבון שלך.',
            'howWouldYouLikeToPay'    => 'כיצד תרצה לשלם?',
            'or'                      => 'או',
            'payWith'                 => 'שלם עם',
            'insertCardDetails'       => 'הזן פרטי כרטיס',
            'payNow'                  => 'שלם עכשיו',
            'invoice-success'         => 'החשבונית שולמה.',
            'invoice-failed'          => 'החשבונית לא שולמה עקב :error',
            'method-unavailable'      => 'שיטת תשלום זו אינה זמינה, אנא נסה שיטה אחרת',
            'invalidWebhookData'      => 'נתוני Webhook שגויים',
            'noWebhookSignature'      => 'חתימת Webhook אינה זמינה.',
            'noWebhookSecretKey'      => 'מפתח סודי של Webhook אינו זמין.',
            'invalidWebhookSignature' => 'חתימת Webhook שגויה.',
        ],

        'error' => [
            'page-title' => 'שגיאת MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'שם על הכרטיס',
                'cardNumber'           => 'מספר כרטיס',
                'expiryDate'           => 'תאריך תפוגה',
                'securityCode'         => 'קוד אבטחה',
                'cardHolderNameLabel'  => 'שם בעל הכרטיס',
                'cardNumberLabel'      => 'מספר כרטיס',
                'expiryDateLabel'      => 'תאריך תפוגה',
                'securityCodeLabel'    => 'קוד אבטחה',
                'saveCard'             => 'שמור מספר כרטיס לתשלומים עתידיים',
                'addCard'              => 'השתמש בכרטיס אחר',
                'deleteAlert'          => [
                    'title'    => 'מחק כרטיס',
                    'message'  => 'האם אתה בטוח שברצונך למחוק כרטיס זה?',
                    'confirm'  => 'כן',
                    'cancel'   => 'לא',
                ],
            ],
        ],
    ],
];
