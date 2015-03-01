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
