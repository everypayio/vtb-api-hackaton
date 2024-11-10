<?php

namespace App\Providers;

use App\Contracts\BankSuggest;
use App\Services\BankHelperService;
use App\Contracts\BankHelper;
use App\Services\BankSuggestService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\WidgetDataTransformer;
use App\Repositories\BankMongodbRepository;
use App\Repositories\Interfaces\BankRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BankRepositoryInterface::class, BankMongodbRepository::class);
        $this->app->bind(BankHelper::class, BankHelperService::class);
        $this->app->bind(BankSuggest::class, BankSuggestService::class);
        $this->app->bind(WidgetDataTransformer::class, \App\Transformers\WidgetDataTransformer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
