<?php

return [
    'admin' => [
        'configurations'     => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'বর্ণনা',
                        'logo'               => 'লোগো',
                        'description'        => 'নিরাপদ পেমেন্ট মডিউল, পেমেন্ট পদ্ধতির সমর্থন, কার্ড ডেটা সংরক্ষণ, ফেরত সক্ষমতা, এবং রিয়েল-টাইম স্ট্যাটাস আপডেটের জন্য Webhook ইন্টিগ্রেশন',
                        'api-key'            => 'API কী',
                        'test-mode'          => 'পরীক্ষার মোড',
                        'country-iso'        => [
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

        'settings'           => [
            'map-apple-pay' => [
                'title'       => 'Apple Pay ম্যাপ করুন',
                'description' => 'MyFatoorah সেটিংসে Apple Pay ম্যাপ করুন',
                'save-btn'    => 'সংরক্ষণ করুন',
                'back-btn'    => 'পিছনে',
                'url'         => 'URL',
            ],
        ],

        'unexpected-payment' => 'MyFatoorah এই অর্ডারের জন্য :transaction পেমেন্টের তথ্য দিয়েছে যখন অর্ডারটি :status অবস্থায় ছিল। MyFatoorah-এ পেমেন্টটি যাচাই করুন এবং প্রয়োজন না হলে ফেরত দিন।',
        'refund-failed'      => 'MyFatoorah :amount ফেরত দিতে পারেনি: :message',
    ],

    'shop'  => [
        'checkout'   => [
            'page-title'                => 'MyFatoorah - চেকআউট',
            'no-payment-gateways'       => 'আপনার অ্যাকাউন্টে কোন পেমেন্ট পদ্ধতি উপলব্ধ নেই, অনুগ্রহ করে আপনার অ্যাকাউন্ট ম্যানেজারের সাথে যোগাযোগ করুন।',
            'how-would-you-like-to-pay' => 'আপনি কিভাবে পরিশোধ করতে চান?',
            'or'                        => 'অথবা',
            'pay-with'                  => 'পরিশোধ করুন',
            'insert-card-details'       => 'কার্ডের বিবরণ প্রবেশ করান',
            'pay-now'                   => 'এখন পরিশোধ করুন',
            'cancel'                    => 'বাতিল করুন',
            'invoice-success'           => 'চালান পরিশোধ করা হয়েছে।',
            'invoice-failed'            => 'ত্রুটি :error কারণে চালান পরিশোধ হয়নি',
            'method-unavailable'        => 'এই পেমেন্ট পদ্ধতি সক্রিয় নয়, অন্যটি চেষ্টা করুন',
            'invalid-webhook-data'      => 'অবৈধ Webhook ডেটা',
            'no-webhook-signature'      => 'Webhook স্বাক্ষর উপলব্ধ নেই।',
            'no-webhook-secretKey'      => 'Webhook সিক্রেট কী উপলব্ধ নেই।',
            'invalid-webhook-signature' => 'অবৈধ Webhook স্বাক্ষর।',
            'error-occurred'            => 'আপনার অনুরোধ প্রক্রিয়াকরণের সময় একটি ত্রুটি ঘটেছে।',
            'error-title'               => 'পেমেন্ট ত্রুটি',
            'back-to-cart'              => 'কার্টে ফিরে যান',
            'invoice-pending'           => 'আপনার পেমেন্ট এখনও প্রক্রিয়াধীন। MyFatoorah নিশ্চিত করার সাথে সাথে আপনার অর্ডার আপডেট করা হবে।',
        ],

        'error'      => [
            'page-title' => 'MyFatoorah ত্রুটি',
        ],

        'components' => [
            'form' => [
                'holder-name'            => 'কার্ডের নাম',
                'card-number'            => 'নম্বর',
                'expiry-date'            => 'মেয়াদ শেষ হওয়ার তারিখ',
                'security-code'          => 'সুরক্ষা কোড',
                'card-holder-name-label' => 'কার্ড ধারকের নাম',
                'card-number-label'      => 'কার্ড নম্বর',
                'expiry-date-label'      => 'মেয়াদ শেষ হওয়ার তারিখ',
                'security-code-label'    => 'সুরক্ষা কোড',
                'save-card'              => 'ভবিষ্যতের পেমেন্টের জন্য কার্ড নম্বর সংরক্ষণ করুন',
                'add-card'               => 'অন্য কার্ড ব্যবহার করুন',
                'deleteAlert'            => [
                    'title'   => 'কার্ড মুছে ফেলুন',
                    'message' => 'আপনি কি এই কার্ডটি সরাতে চান?',
                    'confirm' => 'হ্যাঁ',
                    'cancel'  => 'না',
                ],
            ],
        ],
    ],
];
