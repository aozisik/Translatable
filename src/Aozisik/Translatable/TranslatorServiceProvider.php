<?php namespace Aozisik\Translatable;

use Illuminate\Support\ServiceProvider;

class TranslatorServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->app['Translator'] = $this->app->share(function($app)
        {
            return new \Aozisik\Translatable\Translator;
        });
    }

    public function register()
    {
        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Translator', 'Aozisik\Translatable\Facades\Translator');
        });
    }

}