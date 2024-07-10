<?php

namespace Webkul\Myfatoorah\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;

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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = $this->ask('Please Enter Your Domain ');

        $request = \Illuminate\Http\Request::create(route('myfatoorah.register.applePay',$domain), 'GET');
        
        $response = json_decode(app()->handle($request)->getContent(), true);

        $this->info($response['IsSuccess'] ? 'Apple Pay Registered Successfully' : $response['Message']);
    }
}
