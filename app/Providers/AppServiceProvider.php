<?php

namespace App\Providers;

use App\Services\ThemeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ThemeService::class);
    }

    public function boot(): void
    {
        try {
            $siteName = DB::table('hlstats_Options')
                ->where('keyname', 'sitename')
                ->value('value');

            if ($siteName) {
                config(['services.hlstats.site_name' => $siteName]);
            }
        } catch (\Throwable) {
            // DB not available (migrations, artisan commands, etc.)
        }
    }
}
