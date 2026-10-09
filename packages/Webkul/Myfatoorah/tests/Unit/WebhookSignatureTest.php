<?php

use Webkul\Myfatoorah\Http\WebhookSignature;

it('accepts a signature computed the way myfatoorah documents the concatenation', function () {
    $secretKey = 'test-secret';

    $fields = [
        'CreatedDate' => '04032021211555',
        'CustomerEmail' => '',
        'CustomerMobile' => '96512345678',
    ];

    $string = implode(',', array_map(
        fn ($key, $value) => "$key=$value",
        array_keys($fields),
        $fields
    ));

    $signature = base64_encode(hash_hmac('sha256', $string, $secretKey, true));

    expect(WebhookSignature::verify($fields, $secretKey, $signature))->toBeTrue();
});

it('treats a null field as an empty string', function () {
    $signature = base64_encode(hash_hmac('sha256', 'a=1,b=', 'secret', true));

    expect(WebhookSignature::verify(['a' => '1', 'b' => null], 'secret', $signature))->toBeTrue();
});

it('rejects a wrong signature', function () {
    expect(WebhookSignature::verify(['a' => '1'], 'secret', 'not-the-right-signature'))->toBeFalse();
});

it('rejects a signature computed with the wrong secret key', function () {
    $signature = base64_encode(hash_hmac('sha256', 'a=1', 'right-secret', true));

    expect(WebhookSignature::verify(['a' => '1'], 'wrong-secret', $signature))->toBeFalse();
});
