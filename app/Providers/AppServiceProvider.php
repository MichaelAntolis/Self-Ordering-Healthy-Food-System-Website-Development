<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;

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
        // Make Str helper available in Blade templates
        Blade::directive('str', function ($expression) {
            return "<?php echo Illuminate\\Support\\Str::$expression; ?>";
        });
        
        // Or make it available globally in views
        view()->share('Str', Str::class);
        
        // Set custom pagination view
        Paginator::defaultView('custom.pagination');
        Paginator::defaultSimpleView('custom.pagination');
    }
}