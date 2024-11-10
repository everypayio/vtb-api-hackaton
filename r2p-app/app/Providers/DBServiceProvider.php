<?php

declare(strict_types=1);

namespace App\Providers;

use MongoDB\Laravel\Connection;
use Illuminate\Support\ServiceProvider;
use App\Repositories\BankMongodbRepository;
use Illuminate\Contracts\Foundation\Application;
use App\Repositories\Interfaces\BankRepositoryInterface;

class DBServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BankRepositoryInterface::class, function (Application $app) {
            /**
             * @var Connection $connection
             */
            $connection = $app['db.connection'];

            return new BankMongodbRepository($connection->getCollection('banks'));
        });
    }
}
