<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'বর্ণনা',
                        'logo'               => 'লোগো',
                        'description'        => 'নিরাপদ পেমেন্ট মডিউল, পেমেন্ট পদ্ধতির সমর্থন, কার্ড ডেটা সংরক্ষণ, ফেরত সক্ষমতা, এবং রিয়েল-টাইম স্ট্যাটাস আপডেটের জন্য Webhook ইন্টিগ্রেশন',
                        'api-key'            => 'API কী',
                        'test-mode'          => 'পরীক্ষার মোড',
                        'country-iso'       => [
                            'title' => 'দেশের ISO',
                            'kwt'   => 'কুয়েত',
                            'sau'   => 'সৌদি আরব',
                            'qat'   => 'কাতার',
                            'bhr'   => 'বাহরাইন',
                            'omn'   => 'ওমান',
                            'jod'   => 'জর্ডান',
                            'egy'   => 'মিশর',
                            'are'   => 'সংযুক্ত আরব আমিরাত',
                        ],
                        'is-webhook-enabled' => 'Webhook সক্রিয় করুন',
                        'save-card'          => 'কার্ড সংরক্ষণ করুন',
                        'webhook-secret-key' => 'Webhook সিক্রেট কী',
                        'register-apple-pay' => 'Apple Pay নিবন্ধন করুন',
                        'status'             => 'স্থিতি',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'              => 'MyFatoorah - চেকআউট',
            'noPaymentGateways'       => 'আপনার অ্যাকাউন্টে কোন পেমেন্ট পদ্ধতি উপলব্ধ নেই, অনুগ্রহ করে আপনার অ্যাকাউন্ট ম্যানেজারের সাথে যোগাযোগ করুন।',
            'howWouldYouLikeToPay'    => 'আপনি কিভাবে পরিশোধ করতে চান?',
            'or'                      => 'অথবা',
            'payWith'                 => 'পরিশোধ করুন',
            'insertCardDetails'       => 'কার্ডের বিবরণ প্রবেশ করান',
            'payNow'                  => 'এখন পরিশোধ করুন',
            'invoice-success'         => 'চালান পরিশোধ করা হয়েছে।',
            'invoice-failed'          => 'ত্রুটি :error কারণে চালান পরিশোধ হয়নি',
            'method-unavailable'      => 'এই পেমেন্ট পদ্ধতি সক্রিয় নয়, অন্যটি চেষ্টা করুন',
            'invalidWebhookData'      => 'অবৈধ Webhook ডেটা',
            'noWebhookSignature'      => 'Webhook স্বাক্ষর উপলব্ধ নেই।',
            'noWebhookSecretKey'      => 'Webhook সিক্রেট কী উপলব্ধ নেই।',
            'invalidWebhookSignature' => 'অবৈধ Webhook স্বাক্ষর।',
            'error-occurred'          => 'আপনার অনুরোধ প্রক্রিয়াকরণের সময় একটি ত্রুটি ঘটেছে।',
        ],

        'error' => [
            'page-title' => 'MyFatoorah ত্রুটি',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'কার্ডের নাম',
                'cardNumber'           => 'নম্বর',
                'expiryDate'           => 'মেয়াদ শেষ হওয়ার তারিখ',
                'securityCode'         => 'সুরক্ষা কোড',
                'cardHolderNameLabel'  => 'কার্ড ধারকের নাম',
                'cardNumberLabel'      => 'কার্ড নম্বর',
                'expiryDateLabel'      => 'মেয়াদ শেষ হওয়ার তারিখ',
                'securityCodeLabel'    => 'সুরক্ষা কোড',
                'saveCard'             => 'ভবিষ্যতের পেমেন্টের জন্য কার্ড নম্বর সংরক্ষণ করুন',
                'addCard'              => 'অন্য কার্ড ব্যবহার করুন',
                'deleteAlert'          => [
                    'title'    => 'কার্ড মুছে ফেলুন',
                    'message'  => 'আপনি কি এই কার্ডটি সরাতে চান?',
                    'confirm'  => 'হ্যাঁ',
                    'cancel'   => 'না',
                ],
            ],
        ],
    ],
];
