<?php

namespace Webkul\Myfatoorah\Exceptions;

use Illuminate\Http\RedirectResponse;
use RuntimeException;

/**
 * Raised inside the refund's database transaction so a refund MyFatoorah did not make is never saved.
 */
class RefundFailedException extends RuntimeException
{
    /**
     * Keep it out of the error log; the refund listener has already logged the reason.
     */
    public function report(): void {}

    /**
     * Send the admin back to the refund form with the reason.
     */
    public function render(): RedirectResponse
    {
        session()->flash('error', $this->getMessage());

        return redirect()->back();
    }
}
