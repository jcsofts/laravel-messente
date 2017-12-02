<?php

namespace Jcsofts\LaravelMessente;


use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use Jcsofts\LaravelMessente\Lib\Messente;

class MessenteServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $dist = __DIR__.'/../config/messente.php';
        if (function_exists('config_path')) {
            // Publishes config File.
            $this->publishes([
                $dist => config_path('messente.php'),
            ]);
        }
        $this->mergeConfigFrom($dist, 'messente');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Messente::class, function ($app) {
            return $this->createInstance($app['config']);
        });
    }

    public function provides()
    {
        return [Messente::class];
    }

    protected function createInstance(Repository $config)
    {
        // Check for messente config file.
        if (! $this->hasConfigSection()) {
            $this->raiseRunTimeException('Missing messente configuration section.');
        }
        // Check for username.
        if ($this->configHasNo('api_username')) {
            $this->raiseRunTimeException('Missing messente configuration: "api_username".');
        }
        // check the password
        if ($this->configHasNo('api_password')) {
            $this->raiseRunTimeException('Missing messente configuration: "api_password".');
        }


        return new Messente($config->get('messente.api_username'), $config->get('messente.api_password'), $config->get('messente.sender'));

    }

    /**
     * Checks if has global messente configuration section.
     *
     * @return bool
     */
    protected function hasConfigSection()
    {
        return $this->app->make(Repository::class)
            ->has('messente');
    }

    /**
     * Checks if Nexmo config does not
     * have a value for the given key.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function configHasNo($key)
    {
        return ! $this->configHas($key);
    }

    /**
     * Checks if messente config has value for the
     * given key.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function configHas($key)
    {
        /** @var Config $config */
        $config = $this->app->make(Repository::class);
        // Check for messente config file.
        if (! $config->has('messente')) {
            return false;
        }
        return
            $config->has('messente.'.$key) &&
            ! is_null($config->get('messente.'.$key)) &&
            ! empty($config->get('messente.'.$key));
    }

    /**
     * Raises Runtime exception.
     *
     * @param string $message
     *
     * @throws \RuntimeException
     */
    protected function raiseRunTimeException($message)
    {
        throw new \RuntimeException($message);
    }
}
