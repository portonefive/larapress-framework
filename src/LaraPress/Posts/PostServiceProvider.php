<?php namespace LaraPress\Posts;

use Illuminate\Support\ServiceProvider;
use LaraPress\Posts\Loop;

class PostServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLoopAndQuery();
        $this->registerPostManager();
        $this->registerPostTypeManager();
        $this->registerPostTypes();
    }

    protected function registerPostManager()
    {
        $this->app['posts'] = $this->app->share(
            function ($app)
            {
                return new Repository($app);
            }
        );
    }

    protected function registerPostTypeManager()
    {
        $this->app['posts.types'] = $this->app->share(
            function ($app)
            {
                return new PostTypeManager($app);
            }
        );
    }

    protected function registerPostTypes()
    {
        foreach (config('posts.types', []) as $postTypeModel)
        {
            $this->app['posts.types']->register($postTypeModel);
        }
    }

    public function provides()
    {
        return ['posts', 'posts.types', 'query', 'loop'];
    }

    protected function registerLoopAndQuery()
    {
        $this->app['actions']->listen(
            'wp',
            function ()
            {
                $this->app->instance('query', $query = Query::newInstanceFromWordpressQuery($GLOBALS['wp_query']));
                $this->app->instance('loop', new Loop($query->get_posts()));
            }
        );
    }
}
