<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'विवरण',
                        'logo'               => 'लोगो',
                        'description'        => 'भुगतान विधियों का समर्थन, कार्ड डेटा भंडारण, वापसी क्षमताओं, और रीयल-टाइम स्थिति अपडेट के लिए वेबहुक एकीकरण के साथ सुरक्षित भुगतान मॉड्यूल',
                        'api-key'            => 'API कुंजी',
                        'test-mode'          => 'टेस्ट मोड',
                        'country-iso'       => [
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
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'MyFatoorah - भुगतान',
            'noPaymentGateways'       => 'आपके खाते पर कोई भुगतान विधियां उपलब्ध नहीं हैं, कृपया अपने खाता प्रबंधक से संपर्क करें।',
            'howWouldYouLikeToPay'    => 'आप कैसे भुगतान करना चाहेंगे?',
            'or'                      => 'या',
            'payWith'                 => 'साथ में भुगतान करें',
            'insertCardDetails'       => 'कार्ड विवरण दर्ज करें',
            'payNow'                  => 'अभी भुगतान करें',
            'invoice-success'         => 'चालान का भुगतान हो गया है।',
            'invoice-failed'          => ':error के कारण चालान का भुगतान नहीं हो पाया है',
            'method-unavailable'      => 'यह भुगतान विधि निष्क्रिय है कृपया कोई अन्य विधि आज़माएं',
            'invalidWebhookData'      => 'अवैध वेबहुक डेटा',
            'noWebhookSignature'      => 'वेबहुक हस्ताक्षर उपलब्ध नहीं है।',
            'noWebhookSecretKey'      => 'वेबहुक गुप्त कुंजी उपलब्ध नहीं है।',
            'invalidWebhookSignature' => 'अवैध वेबहुक हस्ताक्षर।',
            'error-occurred'          => 'आपके अनुरोध को संसाधित करते समय एक त्रुटि हुई।',
        ],

        'error' => [
            'page-title' => 'MyFatoorah त्रुटि',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'कार्ड पर नाम',
                'cardNumber'           => 'संख्या',
                'expiryDate'           => 'समाप्ति तिथि',
                'securityCode'         => 'सीवीवी',
                'cardHolderNameLabel'  => 'कार्ड धारक का नाम',
                'cardNumberLabel'      => 'कार्ड नंबर',
                'expiryDateLabel'      => 'समाप्ति तिथि',
                'securityCodeLabel'    => 'सुरक्षा कोड',
                'saveCard'             => 'भविष्य के भुगतानों के लिए कार्ड नंबर सेव करें',
                'addCard'              => 'दूसरा कार्ड का उपयोग करें',
                'deleteAlert'          => [
                    'title'    => 'कार्ड हटाएं',
                    'message'  => 'क्या आप वाकई इस कार्ड को हटाना चाहते हैं?',
                    'confirm'  => 'हाँ',
                    'cancel'   => 'नहीं',
                ],
            ],
        ],
    ],
];
