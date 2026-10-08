<?php

namespace Webkul\Myfatoorah\Commands;

use Exception;
use Illuminate\Console\Command;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;

class RegisterApplePay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'myfatoorah:register-apple-pay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register your domain with Myfatoorah for Apple pay.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (empty(core()->getConfigData('sales.payment_methods.myfatoorah.api_key'))) {
            $this->info('API key not found');

            return self::FAILURE;
        }

        try {
            $response = $this->registerApplePay((string) $this->ask('What is your domain ?'));
        } catch (Exception $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->info($response['IsSuccess'] ? 'Apple pay registered successfully' : $response['Message']);

        return $response['IsSuccess'] ? self::SUCCESS : self::FAILURE;
    }

    /**
     * Register Apple Pay
     *
     * @param  string  $domain
     *
     * @throws Exception
     */
    public function registerApplePay($domain): array
    {
        $domain = preg_replace('#^https?://#i', '', trim($domain));

        $response = app(MyFatoorahPayment::class)->registerApplePayDomain('https://'.$domain);

        return [
            'IsSuccess' => (bool) ($response->IsSuccess ?? false),
            'Message'   => (string) ($response->Message ?? ''),
        ];
    }
}
