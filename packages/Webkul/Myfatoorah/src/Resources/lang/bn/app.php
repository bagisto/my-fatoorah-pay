<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'payment-title' => 'শিরোনাম',
                        'description-title' => 'বর্ণনা',
                        'logo' => 'লোগো',
                        'description' => 'নিরাপদ পেমেন্ট মডিউল, পেমেন্ট পদ্ধতির সমর্থন, কার্ড ডেটা সংরক্ষণ, ফেরত সক্ষমতা, এবং রিয়েল-টাইম স্ট্যাটাস আপডেটের জন্য Webhook ইন্টিগ্রেশন',
                        'api-key' => 'API কী',
                        'test-mode' => 'পরীক্ষার মোড',
                        'country-iso' => [
                            'title' => 'দেশের ISO',
                            'kwt' => 'কুয়েত',
                            'sau' => 'সৌদি আরব',
                            'qat' => 'কাতার',
                            'bhr' => 'বাহরাইন',
                            'omn' => 'ওমান',
                            'jod' => 'জর্ডান',
                            'egy' => 'মিশর',
                            'are' => 'সংযুক্ত আরব আমিরাত',
                        ],
                        'is-webhook-enabled' => 'Webhook সক্রিয় করুন',
                        'webhook-secret-key' => 'Webhook সিক্রেট কী',
                        'status' => 'স্থিতি',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah :amount ফেরত দিতে পারেনি: :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - চেকআউট',
            'error-title' => 'পেমেন্ট ত্রুটি',
            'back-to-cart' => 'কার্টে ফিরে যান',
        ],
    ],

    'response' => [
        'provide-credentials' => 'অনুগ্রহ করে প্রথমে আপনার MyFatoorah API কী কনফিগার করুন।',
        'cart-not-found' => 'আপনার কার্ট পাওয়া যায়নি।',
        'payment-failed' => 'পেমেন্ট সম্পন্ন করা যায়নি। অনুগ্রহ করে আবার চেষ্টা করুন।',
        'payment-success' => 'আপনার পেমেন্ট সফল হয়েছে!',
    ],
];
