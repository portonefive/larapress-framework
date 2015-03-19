<?php namespace LaraPress\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider {

    /**
     * Boot
     *
     * @return void
     */
    public function register()
    {
        /*
        $this->app['filters']->listen(
            'site_url',
            function ($url)
            {
                if (strpos($url, 'wp-') === false)
                {
                    return str_replace(WP_SITEURL, WP_HOME, $url);
                }

                return $url;
            }
        );
        */

        foreach (config('supports') as $feature => $value)
        {
            if ($value === 'automatic-feed-links')
            {
                $feature = $value;
                add_theme_support($feature);
            }
            else
            {
                add_theme_support($feature, $value);
            }
        }
    }
}
