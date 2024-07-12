# Bagisto MyFatoorah Payment Gateway v2.1.2:

MyFatoorah Payment Module enables get your business up and running in a few minutes. Our developer friendly secure and easy Module will give you more than 20 debit and credit cards in addition to the 10 most common currencies,


# Features

- **Enable Module**: Admins can easily enable/disable the module via configuration settings using their login credentials.
- **Supported Payment Methods**: Users can securely make payments using various methods, including:
  - Debit Cards/Credit Cards
  - Google Pay
  - Apple Pay
  - Custom methods based on your Myfatoorah account API key
- **Card store option**: Option for admins to securely store customer card data at Myfatoorah payment portal for future payments.
- **Refund option**: Supports both partial and total refunds, with some gateways offering instant refund capabilities.
- **Webhook setup**:Webhook option is also available with this module to get payment status for the respective purchages.
- **Supported Countries**: Kuwait, Saudi Arabia, Qatar, Oman, Egypt, Jordan, Bahrain, United Arab Emirates.


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

  

# Configuration

1. How to get API key from the Myfatoorah payment portal.
   -
   Myfatoorah payment portal url:- https://myfatoorah.com/ 
   - Go to Myfatoorah Dashboard
   - Click on "Intregation Settings"
   - Click on "Api Key"

2. How to get webhook secret key from Myfatoorah to link with Bagisto Myfatoorah module.
   -
   - Login to the Bagisto Admin Panel.
   - Navigate to the "Configuration" and under Payment Methods find out Myfatoorah Payment Module.
   - Enable the Myfatoorah Webhook and copy the webhook endpoint to set it in Myfatoorah Payment portal.
   - Login to Myfatoorah Dashboard and go to Intregation Settings > Webhook Settings and follow the below steps.

      1. Enable Webhook from the settings.
      2. Paste endpoint which is taken from Bagisto Myfatoorah Payment Module.
      3. Select respective events as per your choice.
      4. Generate Webhook Secret Key and Copy the secret to add into Bagisto Myfatoorah payment Module under webhook secret section.
      5. Click on save button.

3. Apple Pay registration steps.
   -

   Host your domain verification file

   - Create a folder in the root path and name it ".well-known"
   
   - Paste the domain verificatoin file inside the ".well-known" folder.
   
   - Test that the file is located in the correct place by opening the below URL https://{example.com}/.well-known/apple-developer-merchantid-domain-association
  
   - Run the command
      ~~~
      php artisan myfatoorah:register-apple-pay
      ~~~
Note: 
* Apple pay registration is required if you need "Apple Pay" payment option
  

