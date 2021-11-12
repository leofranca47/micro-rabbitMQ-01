<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Company;
use App\Observers\CategoryObserve;
use App\Observers\CompanyObserver;
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
        Category::observe(CategoryObserve::class);
        Company::observe(CompanyObserver::class);
    }
}
