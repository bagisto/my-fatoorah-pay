# MyFatoorah Payment Gateway v2.1.2:

MyFatoorah Payment Module enables get your business up and running in a few minutes. Our developer friendly secure and easy Module will give you more than 20 debit and credit cards in addition to the 10 most common currencies,


# Features

* Admin can enable Setting for save your customer card data for future payment.
* we support partial and total refund. Moreover, Instant refund is supported for some gateways.
* Payment enquiry to get the status of any invoice or transaction
* webhook to trigger an event to your endpoint to be updated with all the status changes for your transaction, refund, deposits...


# Requirements:

* **Bagisto**: v2.1.2.
* **PHP**: v8.1 or Higher.

# Installation:

1. Unzip the respective extension zip and then merge "packages" and "storage" folders into project root directory.
   
2. Goto composer.json file and add following line under 'psr-4'

~~~
"Webkul\\Myfatoorah\\": "packages/Webkul/Myfatoorah/src"
~~~

2. Goto config/app.php file and add following line under 'providers'

~~~
Webkul\Myfatoorah\Providers\MyfatoorahServiceProvider::class,
~~~

3. Go to *config/bagisto-vite.php* add the following line under the 'viters' section
~~~
'myfatoorah' => [
    'hot_file'                 => 'myfatoorah-default-vite.hot',
    'build_directory'          => 'themes/myfatoorah/default/build',
    'package_assets_directory' => 'src/Resources/assets',
],
~~~

4. Install library

~~~
composer require myfatoorah/library
~~~

5. Perform a command, from the root of your terminal:

~~~
composer dump-autoload

php artisan optimize:clear

php artisan vendor:publish --force

> Press the number before "Webkul\Myfatoorah\Providers\MyfatoorahServiceProvider::class" or search "Webkul\Myfatoorah\Providers\MyfatoorahServiceProvider::class"  and then press enter to publish all assets and configurations.
~~~

~~~
cd packages/MyFatoorah

npm i

npm build
~~~

# Configuration:

1. API key(required) => Go to you Myfatoorah Dashboard -> Home > Interagation Settings > Api Key
2. Is Your MyFatoorah Account is for Testing
3. Country ISO(required)
4. Webhook Key =>Go to you Myfatoorah Dashboard -> Home > Interagation Settings > Webhook Settings
   * Enable the Webhook
   * Enter you domail with 'myfatoorah/webhook' for Example -> https://www.example.com/myfatoorah/webhook
   * Enable Secret Key
   * Genrate Secret 
   * Select The Webhook Events 
5. Register Apple Pay
   
   Host your domain verification file

   1- Create a folder in the root path and name it ".well-known"
   
   2- Paste the domain verificatoin file inside the ".well-known" folder.
   
   3- Test that the file is located in the correct place by opening the below URL
   
   https://{example.com}/.well-known/apple-developer-merchantid-domain-association
  
   Run the command
   ~~~
   php artisan myfatoorah:register-apple-pay
   ~~~

Note: 
* Current currency should be  USD/KWD
  

