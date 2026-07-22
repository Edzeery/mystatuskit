<?php

namespace Edzeery\MyStatusKit;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class StatusKitServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/icons.php', 'status-kit-icons');
        $this->mergeConfigFrom(__DIR__.'/../config/statuses.php', 'status-kit-statuses');
        $this->mergeConfigFrom(__DIR__.'/../config/theme.php', 'status-kit-theme');

        $this->app->singleton(IconManager::class, fn () => new IconManager);
        $this->app->singleton('status-kit-icon', fn ($app) => $app->make(IconManager::class));

        $this->app->singleton(StatusManager::class, fn ($app) => new StatusManager($app->make(IconManager::class)));
        $this->app->singleton('status-kit', fn ($app) => $app->make(StatusManager::class));
    }

    public function boot(): void
    {
        // نشر الملفات القابلة للتخصيص
        $this->publishes([
            __DIR__.'/../config/icons.php' => config_path('status-kit-icons.php'),
            __DIR__.'/../config/statuses.php' => config_path('status-kit-statuses.php'),
            __DIR__.'/../config/theme.php' => config_path('status-kit-theme.php'),
        ], 'status-kit-config');

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/status-kit'),
        ], 'status-kit-lang');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/status-kit'),
        ], 'status-kit-views');

        $this->publishes([
            __DIR__.'/../resources/svg' => resource_path('svg'),
        ], 'status-kit-svg');

        $this->publishes([
            __DIR__.'/../src/Casts' => app_path('Casts/StatusKit'),
        ], 'status-kit-casts');

        // تحميل المصادر مباشرة (تعمل حتى بدون نشر)
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'status-kit');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'status-kit');

        $this->mergePublishedConfigs();
        $this->registerBladeComponents();
    }

    /**
     * دمج configs المنشورة يدوياً (لأن أسماء الملفات المنشورة تختلف عن مفاتيح config).
     */
    private function mergePublishedConfigs(): void
    {
        $mappings = [
            'status-kit-icons.php' => 'status-kit-icons',
            'status-kit-statuses.php' => 'status-kit-statuses',
            'status-kit-theme.php' => 'status-kit-theme',
        ];

        foreach ($mappings as $file => $key) {
            $path = config_path($file);
            if (is_file($path)) {
                $this->app['config']->set($key, array_replace_recursive(
                    config($key, []),
                    require $path
                ));
            }
        }
    }

    private function registerBladeComponents(): void
    {
        Blade::component('status-kit::components.status-badge', 'status-badge');
        Blade::component('status-kit::components.status-icon', 'status-icon');
        Blade::component('status-kit::components.status-select', 'status-select');
        Blade::component('status-kit::components.status-dot', 'status-dot');

        Blade::directive('statusKitAssets', function ($expression) {
            return "<?php echo \\Edzeery\\MyStatusKit\\Support\\AssetsRenderer::render({$expression}); ?>";
        });

        Blade::component('status-kit::components.status-badge-wire', 'status-badge-wire');
        Blade::component('status-kit::components.status-progress', 'status-progress');

        Blade::directive('statusFor', function (string $expression) {
            return "<?php foreach(\\Edzeery\\MyStatusKit\\Facades\\Status::domain({$expression}) as \$key => \$statusResult): ?>";
        });

        Blade::directive('endStatusFor', function () {
            return '<?php endforeach; ?>';
        });

        Blade::directive('statusLegend', function (string $expression) {
            return "<?php
                \$__statusLegendDomain = {$expression};
                \$__statusLegendItems = \\Edzeery\\MyStatusKit\\Facades\\Status::domain(\$__statusLegendDomain);
            ?>";
        });

        Blade::directive('endStatusLegend', function () {
            return '<?php endforeach; ?>';
        });
    }
}
