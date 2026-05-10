<?php

namespace App\Providers;

use App\Models\News;
use App\Models\User;
use App\Policies\NewsPolicy;
use Illuminate\Support\Facades\Gate;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * 1 - admin
         * 2 - editor
         * 3 - author
         */
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(News::class, NewsPolicy::class);
        View::composer('news.latestnews.sidebar', function ($view) {
            $latestNews = News::latest()
                ->take(5)
                ->get();

            $view->with('latestNews', $latestNews);
        });
    }
}
