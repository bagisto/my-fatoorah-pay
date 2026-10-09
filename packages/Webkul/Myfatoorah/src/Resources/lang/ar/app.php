<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'ماي فاتورة',
                        'description-title' => 'الوصف',
                        'logo' => 'شعار',
                        'description' => 'وحدة دفع آمنة مع دعم طرق الدفع، تخزين بيانات البطاقة، قدرات الاسترداد، وتكامل Webhook لتحديثات الحالة في الوقت الفعلي',
                        'api-key' => 'مفتاح API',
                        'test-mode' => 'وضع الاختبار',
                        'country-iso' => [
                            'title' => 'رمز ISO للبلد',
                            'kwt' => 'الكويت',
                            'sau' => 'المملكة العربية السعودية',
                            'qat' => 'قطر',
                            'bhr' => 'البحرين',
                            'omn' => 'عمان',
                            'jod' => 'الأردن',
                            'egy' => 'مصر',
                            'are' => 'الإمارات العربية المتحدة',
                        ],
                        'is-webhook-enabled' => 'تفعيل Webhook',
                        'webhook-secret-key' => 'مفتاح Webhook السري',
                        'status' => 'الحالة',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'تعذر على MyFatoorah استرداد :amount: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'ماي فاتورة - الدفع',
            'error-title' => 'خطأ في الدفع',
            'back-to-cart' => 'العودة إلى السلة',
        ],
    ],

    'response' => [
        'provide-credentials' => 'يرجى تكوين مفتاح API الخاص بـ MyFatoorah أولاً.',
        'cart-not-found' => 'تعذر العثور على سلة التسوق الخاصة بك.',
        'payment-failed' => 'تعذر إتمام الدفع. يرجى المحاولة مرة أخرى.',
        'payment-success' => 'تمت عملية الدفع بنجاح!',
    ],
];
