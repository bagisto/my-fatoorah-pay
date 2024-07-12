<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'مای فَتوره',
                        'description-title'  => 'توضیحات',
                        'logo'               => 'لوگو',
                        'description'        => 'ماژول پرداخت امن با پشتیبانی از روش‌های پرداخت، ذخیره‌سازی داده‌های کارت، قابلیت‌های بازپرداخت و ادغام Webhook برای به‌روزرسانی‌های وضعیت در زمان واقعی',
                        'api-key'            => 'کلید API',
                        'test-mode'          => 'حالت آزمایشی',
                        'country-iso'       => [
                            'title' => 'کد ISO کشور',
                            'kwt'   => 'کویت',
                            'sau'   => 'عربستان سعودی',
                            'qat'   => 'قطر',
                            'bhr'   => 'بحرین',
                            'omn'   => 'عمان',
                            'jod'   => 'اردن',
                            'egy'   => 'مصر',
                            'are'   => 'امارات متحده عربی',
                        ],
                        'is-webhook-enabled' => 'فعالسازی Webhook',
                        'save-card'          => 'ذخیره کارت',
                        'webhook-secret-key' => 'کلید محرمانه Webhook',
                        'register-apple-pay' => 'ثبت Apple Pay',
                        'status'             => 'وضعیت',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'مای فَتوره - پرداخت',
            'noPaymentGateways'       => 'روش‌های پرداخت در حساب شما موجود نیست، لطفا با مدیر حساب خود تماس بگیرید.',
            'howWouldYouLikeToPay'    => 'چگونه می‌خواهید پرداخت کنید؟',
            'or'                      => 'یا',
            'payWith'                 => 'پرداخت با',
            'insertCardDetails'       => 'جزئیات کارت را وارد کنید',
            'payNow'                  => 'پرداخت اکنون',
            'invoice-success'         => 'صورت‌حساب پرداخت شده است.',
            'invoice-failed'          => 'به دلیل :error صورت‌حساب پرداخت نشده است',
            'method-unavailable'      => 'این روش پرداخت غیرفعال است، لطفا روش دیگری را امتحان کنید',
            'invalidWebhookData'      => 'داده‌های Webhook نامعتبر است',
            'noWebhookSignature'      => 'امضای Webhook موجود نیست.',
            'noWebhookSecretKey'      => 'کلید محرمانه Webhook موجود نیست.',
            'invalidWebhookSignature' => 'امضای Webhook نامعتبر است.',
            'error-occurred'          => 'در پردازش درخواست شما خطایی رخ داد.',
        ],

        'error' => [
            'page-title' => 'خطای مای فَتوره',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'نام روی کارت',
                'cardNumber'           => 'شماره کارت',
                'expiryDate'           => 'تاریخ انقضاء',
                'securityCode'         => 'کد امنیتی',
                'cardHolderNameLabel'  => 'نام دارنده کارت',
                'cardNumberLabel'      => 'شماره کارت',
                'expiryDateLabel'      => 'تاریخ انقضاء',
                'securityCodeLabel'    => 'کد امنیتی',
                'saveCard'             => 'ذخیره شماره کارت برای پرداخت‌های آینده',
                'addCard'              => 'استفاده از کارت دیگر',
                'deleteAlert'          => [
                    'title'    => 'حذف کارت',
                    'message'  => 'آیا مطمئن هستید که می‌خواهید این کارت را حذف کنید؟',
                    'confirm'  => 'بله',
                    'cancel'   => 'خیر',
                ],
            ],
        ],
    ],
];
