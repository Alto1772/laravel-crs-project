<?php

namespace App\Providers;

use App\View\Composers\SidebarMenuComposer;
use Illuminate\Support\ServiceProvider;

class SidebarMenuServiceProvider extends ServiceProvider
{
    /**
     * Register the sidebar menu contents parsing
     */
    public function boot(): void
    {
        $this->app->make('view')->composer('layouts.sections.sidebar', SidebarMenuComposer::class);
    }
}
