<?php

namespace App\Providers;

use App\Services\SettingsService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('settings', function ($app) {
            return new SettingsService();
        });

        $this->app->alias('settings', SettingsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerBladeDirectives();
    }

    private function registerBladeDirectives(): void
    {
        Blade::directive('setting', function ($expression) {
            return "<?php echo e(settings({$expression})); ?>";
        });

        Blade::directive('settingRaw', function ($expression) {
            return "<?php echo settings({$expression}); ?>";
        });

        Blade::directive('settingFile', function ($expression) {
            $args = str_getcsv($expression, ',', "'", '\\');
            $key = trim($args[0] ?? '', "'\"");
            $conversion = isset($args[1]) ? "'" . trim($args[1], "'\"") . "'" : 'null';

            return "<?php echo e(setting_file('{$key}', {$conversion})); ?>";
        });

        Blade::directive('hasSetting', function ($expression) {
            return "<?php if(has_setting({$expression})): ?>";
        });

        Blade::directive('endHasSetting', function () {
            return "<?php endif; ?>";
        });
    }
}
