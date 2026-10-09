<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'مای فَتوره',
                        'description-title' => 'توضیحات',
                        'logo' => 'لوگو',
                        'description' => 'ماژول پرداخت امن با پشتیبانی از روش‌های پرداخت، ذخیره‌سازی داده‌های کارت، قابلیت‌های بازپرداخت و ادغام Webhook برای به‌روزرسانی‌های وضعیت در زمان واقعی',
                        'api-key' => 'کلید API',
                        'test-mode' => 'حالت آزمایشی',
                        'country-iso' => [
                            'title' => 'کد ISO کشور',
                            'kwt' => 'کویت',
                            'sau' => 'عربستان سعودی',
                            'qat' => 'قطر',
                            'bhr' => 'بحرین',
                            'omn' => 'عمان',
                            'jod' => 'اردن',
                            'egy' => 'مصر',
                            'are' => 'امارات متحده عربی',
                        ],
                        'is-webhook-enabled' => 'فعالسازی Webhook',
                        'webhook-secret-key' => 'کلید محرمانه Webhook',
                        'status' => 'وضعیت',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah نتوانست :amount را بازپرداخت کند: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'مای فَتوره - پرداخت',
            'error-title' => 'خطای پرداخت',
            'back-to-cart' => 'بازگشت به سبد خرید',
        ],
    ],

    'response' => [
        'provide-credentials' => 'لطفاً ابتدا کلید API مای‌فتوره خود را پیکربندی کنید.',
        'cart-not-found' => 'سبد خرید شما یافت نشد.',
        'payment-failed' => 'پرداخت تکمیل نشد. لطفاً دوباره تلاش کنید.',
        'payment-success' => 'پرداخت شما با موفقیت انجام شد!',
    ],
];
