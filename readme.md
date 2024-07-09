# MyFatoorah Payment Gateway v2.1.2:

This is a addon that will work over Bagisto and it will help admin to get more and more control over
their shops.

# Requirements:

* **Bagisto**: v2.1.2.
* **PHP**: v8.1 or Higher.

# Installation:

1. Goto *composer.json* present in your project's root:

Under the object of *psr-4*, add the line below:

~~~
"Webkul\\Myfatoorah\\": "packages/Webkul/Myfatoorah/src"
~~~

2. Goto *config/app.php* from the project's root:

Under the *providers* array, add this line at the end:

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

php artisan vendor:publish --force

> Press the number before "Webkul\Myfatoorah\Providers\MyfatoorahServiceProvider::class" or search "Webkul\Myfatoorah\Providers\MyfatoorahServiceProvider::class"  and then press enter to publish all assets and configurations.
~~~

~~~
cd packages/MyFatoorah

npm i

npm build
~~~

Note: Current currency should be  USD/KWD