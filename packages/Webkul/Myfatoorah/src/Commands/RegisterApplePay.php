<?php

namespace Webkul\Myfatoorah\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use MyFatoorah\Library\MyFatoorah;

class RegisterApplePay extends Command
{

    public function __construct(protected MyFatoorah $myfatoorah)
    {
        parent::__construct();
    }
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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = $this->ask('Please Enter Your Domain ');
        
        if (! empty(core()->getConfigData('sales.payment_methods.myfatoorah.api_key'))) {

            $request = $this->registerApplePay($domain);
            
            $response = json_decode($request->getBody(), true);
    
            $this->info($response['IsSuccess'] ? 'Apple Pay Registered Successfully' : $response['Message']);
        } else {

            $this->info('API Key Not Found');
        }
    }

    /**
     * Register Apple Pay
     * 
     * @param  string $domain
     * 
     * @return object|json
     */
    public function registerApplePay($domain)
    {

            $result = Http::withHeaders([
                "Authorization" => "Bearer ".core()->getConfigData('sales.payment_methods.myfatoorah.api_key'),
            ])->post($this->myfatoorah->getApiURL(). '/V2/RegisterApplePayDomain', [
                "DomainName" =>$domain,
            ]);

            return $result;
    }
}
