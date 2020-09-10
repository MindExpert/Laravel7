<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use App\View\Components\Badge;
use App\View\Components\Updated;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('badge', Badge::class);
        Blade::component('updated', Updated::class);
        // Blade::component('components.badge', 'badge');

        // Using class based composers...
        // View::composer(
        //     'posts.index', ActivityComposer::class,
        // );

        view()->composer(['posts.index', 'posts.show'], ActivityComposer::class);
    }
}
