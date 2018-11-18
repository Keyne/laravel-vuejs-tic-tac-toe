<?php

namespace App\Providers;

use App\Components\WinnerChecker;
use App\Components\WinnerCheckerInterface;
use App\Services\MatchesService;
use App\Services\MatchesServiceInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        MatchesServiceInterface::class => MatchesService::class,
        WinnerCheckerInterface::class => WinnerChecker::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
