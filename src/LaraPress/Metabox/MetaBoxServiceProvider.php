<?php namespace LaraPress\MetaBox;

use Illuminate\Support\ServiceProvider;

class MetaBoxServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['metabox'] = $this->app->share(
            function ($app)
            {
                return new MetaBoxManager();
            }
        );
    }
}