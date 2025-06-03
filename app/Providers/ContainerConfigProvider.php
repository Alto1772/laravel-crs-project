<?php

namespace App\Providers;

use App\Services\KnnService;
use App\Services\UserQuestionnaireService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class ContainerConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(UserQuestionnaireService::class, function () {
            return new UserQuestionnaireService(Session::get('survey.randseed', 0));
        });
        $this->app->singleton(KnnService::class, function () {
            return new KnnService('http://' . Config::get('knn.host') . ':' . Config::get('knn.port'));
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
