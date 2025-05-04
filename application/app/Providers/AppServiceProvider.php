<?php

namespace App\Providers;

use App\Services\TrainAIService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

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
        if (!defined('AI_SERVER')) {
            define(
                'AI_SERVER',
                env('AI_SERVER', 'http://assistly-ai-server:3000')
            );
        }

        if (!defined('AI_SERVER_API')) {
            define('AI_SERVER_API', AI_SERVER . '/api/v1');
        }


        $this->app->singleton(TrainAIService::class);
        Model::unguard();
    }
}
