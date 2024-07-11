# Bagisto MyFatoorah Payment Gateway v2.1.2:

MyFatoorah Payment Module enables get your business up and running in a few minutes. Our developer friendly secure and easy Module will give you more than 20 debit and credit cards in addition to the 10 most common currencies,


# Features

- **Enable Module**: Admins can easily enable/disable the module via configuration settings using their login credentials.
- **Supported Payment Methods**: Users can securely make payments using various methods, including:
  - Debit Cards/Credit Cards
  - Google Pay
  - Apple Pay
  - Custom methods based on your Myfatoorah account API key
- **Card store option**: Option for admins to securely store customer card data for future payments.
- **Refund option**: Supports both partial and total refunds, with some gateways offering instant refund capabilities.
- **Webhook setup steps**: Easily set up Webhooks to receive real-time status updates for transactions, refunds, and deposits. Follow these steps for Webhook integration:
  1. Access the Bagisto Admin Panel.
  2. Navigate to the "Configuration" tab in the Sidebar.
  3. Select the "Payment Methods" tab under the "Sales" section.
  4. Enable the Myfatoorah Webhook and copy the link provided under the "Webhook Secret Key" field.
  5. Go to your Myfatoorah Dashboard and go to > Interaction Settings > Webhook Settings.
  6. Activate Webhook and paste the copied link from the Bagisto admin.
  7. Enable the Secret Key and generate the Webhook Secret key. Copy the generated key.
  8. Choose the relevant Webhook Events and save your settings.
  9. Return to the Bagisto admin, paste the Webhook Secret key, and save your changes.
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

**Myfatoorah official link**
- https://myfatoorah.com/
  

# Configuration:

1. API key
   -
   Step to get API key:
   - Go to you Myfatoorah Dashboard
   - Click on "Interagation Settings"
   - Click on "Api Key"
  
2. Register Apple Pay
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
  

