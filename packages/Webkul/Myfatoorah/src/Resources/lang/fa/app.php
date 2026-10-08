<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'مای فَتوره',
                        'description-title'  => 'توضیحات',
                        'logo'               => 'لوگو',
                        'description'        => 'ماژول پرداخت امن با پشتیبانی از روش‌های پرداخت، ذخیره‌سازی داده‌های کارت، قابلیت‌های بازپرداخت و ادغام Webhook برای به‌روزرسانی‌های وضعیت در زمان واقعی',
                        'api-key'            => 'کلید API',
                        'test-mode'          => 'حالت آزمایشی',
                        'country-iso'        => [
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

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'اتصال Apple Pay',
                'description' => 'اتصال Apple Pay در تنظیمات MyFatoorah',
                'save-btn'    => 'ذخیره',
                'back-btn'    => 'بازگشت',
                'url'         => 'نشانی',
            ],
        ],

        'unexpected-payment' => 'MyFatoorah پرداخت :transaction را برای این سفارش در حالی گزارش کرد که وضعیت آن :status بود. پرداخت را در MyFatoorah بررسی کنید و در صورت عدم نیاز آن را بازپرداخت کنید.',
        'refund-failed'      => 'MyFatoorah نتوانست :amount را بازپرداخت کند: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'مای فَتوره - پرداخت',
            'no-payment-gateways'       => 'روش‌های پرداخت در حساب شما موجود نیست، لطفا با مدیر حساب خود تماس بگیرید.',
            'how-would-you-like-to-pay' => 'چگونه می‌خواهید پرداخت کنید؟',
            'or'                        => 'یا',
            'pay-with'                  => 'پرداخت با',
            'insert-card-details'       => 'جزئیات کارت را وارد کنید',
            'pay-now'                   => 'پرداخت اکنون',
            'cancel'                    => 'لغو',
            'invoice-success'           => 'صورت‌حساب پرداخت شده است.',
            'invoice-failed'            => 'به دلیل :error صورت‌حساب پرداخت نشده است',
            'method-unavailable'        => 'این روش پرداخت غیرفعال است، لطفا روش دیگری را امتحان کنید',
            'invalid-webhook-data'      => 'داده‌های Webhook نامعتبر است',
            'no-webhook-signature'      => 'امضای Webhook موجود نیست.',
            'no-webhook-secretKey'      => 'کلید محرمانه Webhook موجود نیست.',
            'invalid-webhook-signature' => 'امضای Webhook نامعتبر است.',
            'error-occurred'            => 'در پردازش درخواست شما خطایی رخ داد.',
            'error-title'               => 'خطای پرداخت',
            'back-to-cart'              => 'بازگشت به سبد خرید',
            'invoice-pending'           => 'پرداخت شما هنوز در حال پردازش است. به محض تأیید MyFatoorah سفارش شما به‌روزرسانی می‌شود.',
        ],

        'error'      => [
            'page-title' => 'خطای مای فَتوره',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'نام روی کارت',
                'card-number'            => 'شماره کارت',
                'expiry-date'            => 'تاریخ انقضاء',
                'security-code'          => 'کد امنیتی',
                'card-holder-name-label' => 'نام دارنده کارت',
                'card-number-label'      => 'شماره کارت',
                'expiry-date-label'      => 'تاریخ انقضاء',
                'security-code-label'    => 'کد امنیتی',
                'save-card'              => 'ذخیره شماره کارت برای پرداخت‌های آینده',
                'add-card'               => 'استفاده از کارت دیگر',
                'deleteAlert'            => [
                    'title'   => 'حذف کارت',
                    'message' => 'آیا مطمئن هستید که می‌خواهید این کارت را حذف کنید؟',
                    'confirm' => 'بله',
                    'cancel'  => 'خیر',
                ],
            ],
        ],
    ],
];
