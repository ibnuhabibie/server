<?php

namespace App\Providers;

use App\DynamoDbShare;
use App\Repositories\ShareRepository;
use App\Share;
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
        $this->app->singleton(ShareRepository::class, function ($app)
        {
            $adapter = $app['config']->get('database.storage');

            return new ShareRepository($adapter === 'dynamodb' ? new DynamoDbShare() : new Share());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
