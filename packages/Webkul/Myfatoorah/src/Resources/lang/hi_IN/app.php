<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'payment-title' => 'शीर्षक',
                        'description-title' => 'विवरण',
                        'logo' => 'लोगो',
                        'description' => 'भुगतान विधियों का समर्थन, कार्ड डेटा भंडारण, वापसी क्षमताओं, और रीयल-टाइम स्थिति अपडेट के लिए वेबहुक एकीकरण के साथ सुरक्षित भुगतान मॉड्यूल',
                        'api-key' => 'API कुंजी',
                        'test-mode' => 'टेस्ट मोड',
                        'country-iso' => [
                            'title' => 'देश ISO',
                            'kwt' => 'कुवैत',
                            'sau' => 'सऊदी अरब',
                            'qat' => 'कतर',
                            'bhr' => 'बहरीन',
                            'omn' => 'ओमान',
                            'jod' => 'जॉर्डन',
                            'egy' => 'मिस्र',
                            'are' => 'संयुक्त अरब अमीरात',
                        ],
                        'is-webhook-enabled' => 'वेबहुक सक्षम करें',
                        'webhook-secret-key' => 'वेबहुक गुप्त कुंजी',
                        'status' => 'स्थिति',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah :amount वापस नहीं कर सका: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - भुगतान',
            'error-title' => 'भुगतान त्रुटि',
            'back-to-cart' => 'कार्ट पर वापस जाएं',
        ],
    ],

    'response' => [
        'provide-credentials' => 'कृपया पहले अपनी MyFatoorah API कुंजी कॉन्फ़िगर करें।',
        'cart-not-found' => 'आपकी कार्ट नहीं मिल सकी।',
        'payment-failed' => 'भुगतान पूरा नहीं हो सका। कृपया पुनः प्रयास करें।',
        'payment-success' => 'आपका भुगतान सफल रहा!',
    ],
];
