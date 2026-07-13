<?php

namespace Edzeery\MyStatusKit;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class StatusKitServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/icons.php', 'status-kit-icons');
        $this->mergeConfigFrom(__DIR__ . '/../config/statuses.php', 'status-kit-statuses');
        $this->mergeConfigFrom(__DIR__ . '/../config/theme.php', 'status-kit-theme');

        $this->app->singleton(IconManager::class, fn () => new IconManager());
        $this->app->singleton('status-kit-icon', fn ($app) => $app->make(IconManager::class));

        $this->app->singleton(StatusManager::class, fn ($app) => new StatusManager($app->make(IconManager::class)));
        $this->app->singleton('status-kit', fn ($app) => $app->make(StatusManager::class));
    }

    public function boot(): void
    {
        // نشر الملفات القابلة للتخصيص
        $this->publishes([
            __DIR__ . '/../config/icons.php'    => config_path('icons.php'),
            __DIR__ . '/../config/statuses.php' => config_path('statuses.php'),
            __DIR__ . '/../config/theme.php'    => config_path('status-kit-theme.php'),
        ], 'status-kit-config');

        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/status-kit'),
        ], 'status-kit-lang');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/status-kit'),
        ], 'status-kit-views');

        $this->publishes([
            __DIR__ . '/../resources/svg' => resource_path('svg'),
        ], 'status-kit-svg');

        // تحميل المصادر مباشرة (تعمل حتى بدون نشر)
        // ملاحظة: namespace الترجمة "status-kit" لازم يطابق اسم مجلد النشر أعلاه
        // (lang/vendor/status-kit) حتى تُقرأ الترجمات المخصصة تلقائيًا بعد النشر.
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'status-kit');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'status-kit');

        // إن قام المستخدم بنشر config/statuses.php أو config/icons.php أو config/status-kit-theme.php
        // محليًا، تُدمج فوق الافتراضي
        if (is_file(config_path('icons.php'))) {
            $this->app['config']->set('status-kit-icons', array_replace_recursive(
                config('status-kit-icons', []),
                require config_path('icons.php')
            ));
        }
        if (is_file(config_path('statuses.php'))) {
            $this->app['config']->set('status-kit-statuses', array_replace_recursive(
                config('status-kit-statuses', []),
                require config_path('statuses.php')
            ));
        }
        if (is_file(config_path('status-kit-theme.php'))) {
            $this->app['config']->set('status-kit-theme', array_replace_recursive(
                config('status-kit-theme', []),
                require config_path('status-kit-theme.php')
            ));
        }

        Blade::component('status-kit::components.status-badge', 'status-badge');

        // @statusKitAssets(['fa','bi']) لإدراج روابط CDN لمكتبات الأيقونات مباشرة
        Blade::directive('statusKitAssets', function ($expression) {
            return "<?php echo \\Edzeery\\MyStatusKit\\Support\\AssetsRenderer::render({$expression}); ?>";
        });
    }
}
