<?php

use Webkul\Myfatoorah\Payment\Myfatoorah;

return [
    'myfatoorah' => [
        'code' => 'myfatoorah',
        'title' => 'MyFatoorah',
        'description' => 'MyFatoorah',
        'class' => Myfatoorah::class,
        'active' => true,
        'test_mode' => true,
        'api_key' => 'API_KEY',
        'country_iso' => 'KWT',
        'sort' => 1,
    ],
];
