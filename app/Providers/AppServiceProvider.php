<?php

namespace App\Providers;

use Schema;
use App\Comment;
use App\BlogPost;
use App\Services\Counter;
use App\View\Components\Badge;
use App\View\Components\Updated;
use App\Observers\CommentObserver;
use App\Observers\BlogPostObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\ActivityComposer;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Comment as CommentResource;

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
        Schema::defaultStringLength(191);
        
        Blade::component('badge', Badge::class);
        Blade::component('updated', Updated::class);
        // Blade::component('components.badge', 'badge');

        // Using class based composers...
        // View::composer(
        //     'posts.index', ActivityComposer::class,
        // );
        view()->composer(['posts.index', 'posts.show'], ActivityComposer::class);
        BlogPost::observe(BlogPostObserver::class);
        Comment::observe(CommentObserver::class);

        $this->app->singleton(Counter::class, function($app){
            return new Counter(env('COUNTER_TIMEOUT', 5));
        });

        // Without the data: [] wrapping in postman
        // CommentResource::withoutWrapping();
        // Remove the data wrappfrom all resources
        JsonResource::withoutWrapping();
    }
}
