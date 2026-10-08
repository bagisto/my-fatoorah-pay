<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'विवरण',
                        'logo'               => 'लोगो',
                        'description'        => 'भुगतान विधियों का समर्थन, कार्ड डेटा भंडारण, वापसी क्षमताओं, और रीयल-टाइम स्थिति अपडेट के लिए वेबहुक एकीकरण के साथ सुरक्षित भुगतान मॉड्यूल',
                        'api-key'            => 'API कुंजी',
                        'test-mode'          => 'टेस्ट मोड',
                        'country-iso'        => [
                            'title' => 'देश ISO',
                            'kwt'   => 'कुवैत',
                            'sau'   => 'सऊदी अरब',
                            'qat'   => 'कतर',
                            'bhr'   => 'बहरीन',
                            'omn'   => 'ओमान',
                            'jod'   => 'जॉर्डन',
                            'egy'   => 'मिस्र',
                            'are'   => 'संयुक्त अरब अमीरात',
                        ],
                        'is-webhook-enabled' => 'वेबहुक सक्षम करें',
                        'save-card'          => 'कार्ड सेव करें',
                        'webhook-secret-key' => 'वेबहुक गुप्त कुंजी',
                        'register-apple-pay' => 'Apple Pay पंजीकृत करें',
                        'status'             => 'स्थिति',
                    ],
                ],
            ],
        ],

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'Apple Pay मैप करें',
                'description' => 'MyFatoorah सेटिंग्स में Apple Pay मैप करें',
                'save-btn'    => 'सहेजें',
                'back-btn'    => 'वापस',
                'url'         => 'URL',
            ],
        ],

        'unexpected-payment' => 'MyFatoorah ने इस ऑर्डर के लिए भुगतान :transaction की सूचना दी जब इसकी स्थिति :status थी। MyFatoorah में भुगतान की जाँच करें और आवश्यकता न होने पर उसे वापस करें।',
        'refund-failed'      => 'MyFatoorah :amount वापस नहीं कर सका: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'MyFatoorah - भुगतान',
            'no-payment-gateways'       => 'आपके खाते पर कोई भुगतान विधियां उपलब्ध नहीं हैं, कृपया अपने खाता प्रबंधक से संपर्क करें।',
            'how-would-you-like-to-pay' => 'आप कैसे भुगतान करना चाहेंगे?',
            'or'                        => 'या',
            'pay-with'                  => 'साथ में भुगतान करें',
            'insert-card-details'       => 'कार्ड विवरण दर्ज करें',
            'pay-now'                   => 'अभी भुगतान करें',
            'cancel'                    => 'रद्द करें',
            'invoice-success'           => 'चालान का भुगतान हो गया है।',
            'invoice-failed'            => ':error के कारण चालान का भुगतान नहीं हो पाया है',
            'method-unavailable'        => 'यह भुगतान विधि निष्क्रिय है कृपया कोई अन्य विधि आज़माएं',
            'invalid-webhook-data'      => 'अवैध वेबहुक डेटा',
            'no-webhook-signature'      => 'वेबहुक हस्ताक्षर उपलब्ध नहीं है।',
            'no-webhook-secretKey'      => 'वेबहुक गुप्त कुंजी उपलब्ध नहीं है।',
            'invalid-webhook-signature' => 'अवैध वेबहुक हस्ताक्षर।',
            'error-occurred'            => 'आपके अनुरोध को संसाधित करते समय एक त्रुटि हुई।',
            'error-title'               => 'भुगतान त्रुटि',
            'back-to-cart'              => 'कार्ट पर वापस जाएं',
            'invoice-pending'           => 'आपका भुगतान अभी संसाधित हो रहा है। MyFatoorah की पुष्टि होते ही आपका ऑर्डर अपडेट कर दिया जाएगा।',
        ],

        'error'      => [
            'page-title' => 'MyFatoorah त्रुटि',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'कार्ड पर नाम',
                'card-number'            => 'संख्या',
                'expiry-date'            => 'समाप्ति तिथि',
                'security-code'          => 'सीवीवी',
                'card-holder-name-label' => 'कार्ड धारक का नाम',
                'card-number-label'      => 'कार्ड नंबर',
                'expiry-date-label'      => 'समाप्ति तिथि',
                'security-code-label'    => 'सुरक्षा कोड',
                'save-card'              => 'भविष्य के भुगतानों के लिए कार्ड नंबर सेव करें',
                'add-card'               => 'दूसरा कार्ड का उपयोग करें',
                'deleteAlert'            => [
                    'title'   => 'कार्ड हटाएं',
                    'message' => 'क्या आप वाकई इस कार्ड को हटाना चाहते हैं?',
                    'confirm' => 'हाँ',
                    'cancel'  => 'नहीं',
                ],
            ],
        ],
    ],
];
