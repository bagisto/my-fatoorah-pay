<?php

namespace Webkul\Myfatoorah\Http;

use MyFatoorah\Library\MyFatoorahWebhook;

class WebhookSignature extends MyFatoorahWebhook
{
    /**
     * Check the signature of a MyFatoorah webhook version 2 request with the library's own data model.
     *
     * @param  array  $request
     */
    public static function isValidV2($request, string $secretKey, string $signature): bool
    {
        return static::checkSignatureValidationV2($request, $secretKey, $signature);
    }
}
