<?php

namespace Webkul\Myfatoorah\Http;

class WebhookSignature
{
    /**
     * Verify an ordered set of webhook fields against MyFatoorah's signature.
     *
     * MyFatoorah signs `key=value,key2=value2,...` with HMAC-SHA256 under the account's secret
     * key, base64 encoded. $orderedFields must already be in the order MyFatoorah's per-event
     * documentation specifies for the event being verified, with null values as empty strings.
     */
    public static function verify(array $orderedFields, string $secretKey, string $signature): bool
    {
        $string = implode(',', array_map(
            fn ($key, $value) => $key.'='.$value,
            array_keys($orderedFields),
            array_map(fn ($value) => $value ?? '', $orderedFields)
        ));

        $expected = base64_encode(hash_hmac('sha256', $string, $secretKey, true));

        return hash_equals($expected, $signature);
    }

    /**
     * Verify a PAYMENT_STATUS_CHANGED (webhook v2) payload's signature.
     *
     * The field order below is not confirmed against a live delivery — MyFatoorah's own docs
     * describe the `key=value,` concatenation but do not reproduce the exact field order for this
     * event. Capture a real sandbox webhook delivery and its `MyFatoorah-Signature` header, then
     * adjust $orderedFields below until the computed signature matches, before relying on this in
     * production. Until confirmed, a real webhook is correctly rejected rather than accepted on a
     * guess.
     */
    public static function isValid(array $payload, string $secretKey, string $signature): bool
    {
        $invoice = $payload['Data']['Invoice'] ?? [];

        $transaction = $payload['Data']['Transaction'] ?? [];

        $orderedFields = [
            'InvoiceId' => $invoice['Id'] ?? null,
            'InvoiceStatus' => $invoice['Status'] ?? null,
            'TransactionId' => $transaction['Id'] ?? null,
            'TransactionStatus' => $transaction['Status'] ?? null,
        ];

        return self::verify($orderedFields, $secretKey, $signature);
    }
}
