<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'ماي فاتورة',
                        'description-title'  => 'الوصف',
                        'logo'               => 'شعار',
                        'description'        => 'وحدة دفع آمنة مع دعم طرق الدفع، تخزين بيانات البطاقة، قدرات الاسترداد، وتكامل Webhook لتحديثات الحالة في الوقت الفعلي',
                        'api-key'            => 'مفتاح API',
                        'test-mode'          => 'وضع الاختبار',
                        'country-iso'        => [
                            'title' => 'رمز ISO للبلد',
                            'kwt'   => 'الكويت',
                            'sau'   => 'المملكة العربية السعودية',
                            'qat'   => 'قطر',
                            'bhr'   => 'البحرين',
                            'omn'   => 'عمان',
                            'jod'   => 'الأردن',
                            'egy'   => 'مصر',
                            'are'   => 'الإمارات العربية المتحدة',
                        ],
                        'is-webhook-enabled' => 'تفعيل Webhook',
                        'save-card'          => 'حفظ البطاقة',
                        'webhook-secret-key' => 'مفتاح Webhook السري',
                        'register-apple-pay' => 'تسجيل Apple Pay',
                        'status'             => 'الحالة',
                    ],
                ],
            ],
        ],

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'ربط Apple Pay',
                'description' => 'ربط Apple Pay في إعدادات MyFatoorah',
                'save-btn'    => 'حفظ',
                'back-btn'    => 'رجوع',
                'url'         => 'الرابط',
            ],
        ],

        'unexpected-payment' => 'أبلغت MyFatoorah عن الدفعة :transaction لهذا الطلب بينما كانت حالته :status. تحقق من الدفعة في MyFatoorah واستردها إذا لم تكن مطلوبة.',
        'refund-failed'      => 'تعذر على MyFatoorah استرداد :amount: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'ماي فاتورة - الدفع',
            'no-payment-gateways'       => 'لا توجد طرق دفع متاحة على حسابك، يرجى الاتصال بمدير حسابك.',
            'how-would-you-like-to-pay' => 'كيف تود الدفع؟',
            'or'                        => 'أو',
            'pay-with'                  => 'ادفع بواسطة',
            'insert-card-details'       => 'أدخل تفاصيل البطاقة',
            'pay-now'                   => 'ادفع الآن',
            'cancel'                    => 'إلغاء',
            'invoice-success'           => 'تم دفع الفاتورة.',
            'invoice-failed'            => 'لم يتم دفع الفاتورة بسبب :error',
            'method-unavailable'        => 'طريقة الدفع هذه غير نشطة، يرجى تجربة طريقة أخرى',
            'invalid-webhook-data'      => 'بيانات Webhook غير صالحة',
            'no-webhook-signature'      => 'توقيع Webhook غير متاح.',
            'no-webhook-secretKey'      => 'مفتاح Webhook السري غير متاح.',
            'invalid-webhook-signature' => 'توقيع Webhook غير صالح.',
            'error-occurred'            => 'حدث خطأ أثناء معالجة طلبك.',
            'error-title'               => 'خطأ في الدفع',
            'back-to-cart'              => 'العودة إلى السلة',
            'invoice-pending'           => 'لا تزال عملية الدفع قيد المعالجة. سيتم تحديث طلبك فور تأكيد MyFatoorah.',
        ],

        'error'      => [
            'page-title' => 'خطأ ماي فاتورة',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'الاسم على البطاقة',
                'card-number'            => 'رقم البطاقة',
                'expiry-date'            => 'تاريخ الانتهاء',
                'security-code'          => 'رمز الأمان',
                'card-holder-name-label' => 'اسم حامل البطاقة',
                'card-number-label'      => 'رقم البطاقة',
                'expiry-date-label'      => 'تاريخ الانتهاء',
                'security-code-label'    => 'رمز الأمان',
                'save-card'              => 'حفظ رقم البطاقة للدفع في المستقبل',
                'add-card'               => 'استخدام بطاقة أخرى',
                'deleteAlert'            => [
                    'title'   => 'حذف البطاقة',
                    'message' => 'هل أنت متأكد أنك تريد إزالة هذه البطاقة؟',
                    'confirm' => 'نعم',
                    'cancel'  => 'لا',
                ],
            ],
        ],
    ],
];
