<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'ماي فاتورة',
                        'description-title'  => 'الوصف',
                        'logo'               => 'شعار',
                        'description'        => 'وحدة دفع آمنة مع دعم طرق الدفع، تخزين بيانات البطاقة، قدرات الاسترداد، وتكامل Webhook لتحديثات الحالة في الوقت الفعلي',
                        'api-key'            => 'مفتاح API',
                        'test-mode'          => 'وضع الاختبار',
                        'currency-iso'       => [
                            'title' => 'رمز العملة',
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
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'ماي فاتورة - الدفع',
            'noPaymentGateways'       => 'لا توجد طرق دفع متاحة على حسابك، يرجى الاتصال بمدير حسابك.',
            'howWouldYouLikeToPay'    => 'كيف تود الدفع؟',
            'or'                      => 'أو',
            'payWith'                 => 'ادفع بواسطة',
            'insertCardDetails'       => 'أدخل تفاصيل البطاقة',
            'payNow'                  => 'ادفع الآن',
            'invoice-success'         => 'تم دفع الفاتورة.',
            'invoice-failed'          => 'لم يتم دفع الفاتورة بسبب :error',
            'method-unavailable'      => 'طريقة الدفع هذه غير نشطة، يرجى تجربة طريقة أخرى',
            'invalidWebhookData'      => 'بيانات Webhook غير صالحة',
            'noWebhookSignature'      => 'توقيع Webhook غير متاح.',
            'noWebhookSecretKey'      => 'مفتاح Webhook السري غير متاح.',
            'invalidWebhookSignature' => 'توقيع Webhook غير صالح.',
            'error-occurred'          => 'حدث خطأ أثناء معالجة طلبك.',
        ],

        'error' => [
            'page-title' => 'خطأ ماي فاتورة',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'الاسم على البطاقة',
                'cardNumber'           => 'رقم البطاقة',
                'expiryDate'           => 'تاريخ الانتهاء',
                'securityCode'         => 'رمز الأمان',
                'cardHolderNameLabel'  => 'اسم حامل البطاقة',
                'cardNumberLabel'      => 'رقم البطاقة',
                'expiryDateLabel'      => 'تاريخ الانتهاء',
                'securityCodeLabel'    => 'رمز الأمان',
                'saveCard'             => 'حفظ رقم البطاقة للدفع في المستقبل',
                'addCard'              => 'استخدام بطاقة أخرى',
                'deleteAlert'          => [
                    'title'    => 'حذف البطاقة',
                    'message'  => 'هل أنت متأكد أنك تريد إزالة هذه البطاقة؟',
                    'confirm'  => 'نعم',
                    'cancel'   => 'لا',
                ],
            ],
        ],
    ],
];
