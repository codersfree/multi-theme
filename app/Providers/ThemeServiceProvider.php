<?php

namespace App\Providers;

use App\Themes\Factories\ThemeFactory;
use App\Themes\Managers\ThemeManager;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('theme', function ($app) {
            $theme = config('app.theme');
            $themeInstance = ThemeFactory::make($theme);
            return new ThemeManager($themeInstance);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
