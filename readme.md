# MyFatoorah Payment Gateway v2.1.2:

MyFatoorah Payment Module enables get your business up and running in a few minutes. Our developer friendly secure and easy Module will give you more than 20 debit and credit cards in addition to the 10 most common currencies,


# Features

- **Module Activation**: Admin can easily enable the module through configuration settings.
- **Payment Processing**: Users can securely make payments using this module, including the following supported payment methods:
  - Debit Cards/Credit Cards
  - Google Pay
  - Apple Pay
- **Customer Card Data Storage**: Option for admins to save customer card data for convenient future payments.
- **Refund Support**: Supports both partial and total refunds; certain gateways also offer instant refund capabilities.
- **Webhook Integration**: Webhook functionality to notify your endpoint of status changes for transactions, refunds, and deposits. If admin needs Webhook integration, follow these steps:
  1. Go to the Bagisto Admin Panel.
  2. Click on the "Configuration" tab from the Sidebar.
  3. Click on the "Payment Methods" tab located in the "Sales" section.
  4. Enable Myfatoorah Webhook and copy the link displayed under the "Webhook Secret Key" field.
  5. Go to your Myfatoorah Dashboard and click on > Interaction Settings > Webhook Settings.
  6. Enable Webhook and paste the link copied from Bagisto admin.
  7. Enable Secret Key and generate the Webhook Secret key. Copy the Secret key.
  8. Check the Webhook Events that you need and save.
  9. Return to the Bagisto admin and paste the Webhook Secret key and save.



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
  

