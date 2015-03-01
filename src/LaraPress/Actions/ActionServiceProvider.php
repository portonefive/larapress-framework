<?php namespace LaraPress\Actions;

use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'actions',
            function ($app)
            {
                return (new Dispatcher($app))->setQueueResolver(
                    function () use ($app)
                    {
                        return $app->make('Illuminate\Contracts\Queue\Queue');
                    }
                );
            }
        );
    }
}
