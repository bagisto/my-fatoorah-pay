<?php

namespace Webkul\Myfatoorah\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use MyFatoorah\Library\MyFatoorah;

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
    protected $description = 'Register your domain with Myfatoorah for Apple Pay.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (! empty(core()->getConfigData('sales.payment_methods.myfatoorah.api_key'))) {

            $response = json_decode($this->registerApplePay($this->ask('What is your domain ?'))->getBody(), true);

            $this->info($response['IsSuccess'] ? 'Apple Pay Registered Successfully' : $response['Message']);
        } else {
            $this->info('API Key Not Found');
        }
    }

    /**
     * Register Apple Pay
     *
     * @param  string  $domain
     * @return object|json
     */
    public function registerApplePay($domain)
    {
        $myfatoorah = new MyFatoorah([
            'apiKey'      => core()->getConfigData('sales.payment_methods.myfatoorah.api_key'),
            'isTest'      => (bool) core()->getConfigData('sales.payment_methods.myfatoorah.test_mode'),
            'countryCode' => core()->getConfigData('sales.payment_methods.myfatoorah.country_iso'),
        ]);

        return Http::withHeaders([
            'Authorization' => 'Bearer '.core()->getConfigData('sales.payment_methods.myfatoorah.api_key'),
        ])->post($myfatoorah->getApiURL().'/V2/RegisterApplePayDomain', [
            'DomainName' => $domain,
        ]);
    }
}
