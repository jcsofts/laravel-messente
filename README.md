<h2 align="center">
    Messente Package for Laravel
</h2>

<p align="center">
    <a href="https://packagist.org/packages/jcsofts/laravel-messente"><img src="https://poser.pugx.org/jcsofts/laravel-messente/v/stable?format=flat-square" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/jcsofts/laravel-messente"><img src="https://poser.pugx.org/jcsofts/laravel-messente/v/unstable?format=flat-square" alt="Latest Unstable Version"></a>    
    <a href="https://packagist.org/packages/jcsofts/laravel-messente"><img src="https://poser.pugx.org/jcsofts/laravel-messente/license?format=flat-square" alt="License"></a>
    <a href="https://packagist.org/packages/jcsofts/laravel-messente"><img src="https://poser.pugx.org/jcsofts/laravel-messente/downloads" alt="Total Downloads"></a>
</p>

## Introduction

This is a simple Laravel Service Provider providing access to the <a href="https://messente.com/documentation/sms-messaging">Messente API</a>

Installation
------------

To install the PHP client library using Composer:

```bash
composer require jcsofts/laravel-messente
```

Alternatively, add these two lines to your composer require section:

```json
{
    "require": {
        "jcsofts/laravel-messente": "^1.0"
    }
}
```

### Laravel 5.5+

If you're using Laravel 5.5 or above, the package will automatically register the `Messente` provider and facade.

### Laravel 5.4 and below

Add `Jcsofts\LaravelMessente\MessenteServiceProvider` to the `providers` array in your `config/app.php`:

```php
'providers' => [
    // Other service providers...

    Jcsofts\LaravelMessente\MessenteServiceProvider::class,
],
```

If you want to use the facade interface, you can `use` the facade class when needed:

```php
use Jcsofts\LaravelMessente\Facade\Messente;
```

Or add an alias in your `config/app.php`:

```php
'aliases' => [
    ...
    'Messente' => Jcsofts\LaravelMessente\Facade\Messente::class,
],
```

### Using Laravel-Messente with Lumen

laravel-messente works with Lumen too! You'll need to do a little work by hand
to get it up and running. First, install the package using composer:


```bash
composer require jcsofts/laravel-messente
```

Next, we have to tell Lumen that our library exists. Update `bootstrap/app.php`
and register the `MessenteServiceProvider`:

```php
$app->register(Jcsofts\LaravelMessente\MessenteServiceProvider::class);
```

Finally, we need to configure the library. Unfortunately Lumen doesn't support
auto-publishing files so you'll have to create the config file yourself by creating
a config directory and copying the config file out of the package in to your project:

```bash
mkdir config
cp vendor/jcsofts/laravel-messagete/config/messente.php config/messente.php
```

At this point, set `MESSENTE_API_USERNAME` and `MESSENTE_API_PASSWORD` in your `.env` file and it should
be working for you. You can test this with the following route:

```php
try{
        $mid=Messente::send('Hello word', '+8618903859445');
        echo $mid;
    }catch(Exception $e){
        echo $e->getMessage();
    }
```

Configuration
-------------

You can use `artisan vendor:publish` to copy the distribution configuration file to your app's config directory:

```bash
php artisan vendor:publish
```

Then update `config/messente.php` with your credentials. Alternatively, you can update your `.env` file with the following:

```dotenv
MESSENTE_API_USERNAME=API Username
MESSENTE_API_PASSWORD=API Password
```

Usage
-----
   
To use the Messente Client Library you can use the facade, or request the instance from the service container:

```php
try{
        $messageId=Messente::send('Hello word', '+8618903859445');
        echo $messageId;
    }catch(Exception $e){
        echo $e->getMessage();
    }
```

Or

```php
$messente = app('Messente');

$messageId=$messente->send('Hello word', '+8618903859445');
```
