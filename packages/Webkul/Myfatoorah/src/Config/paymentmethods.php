<?php

return [
    'myfatoorah'  => [
        'code'        => 'myfatoorah',
        'title'       => 'MyFatoorah',
        'description' => core()->getConfigData('sales.payment_methods.myfatoorah.description'),
        'class'       => 'Webkul\Myfatoorah\Payment\Myfatoorah',
        'active'      => true,
        'sandbox'     => true,
        'sort'        => 1,
    ],
];
