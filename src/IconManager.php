<?php

namespace Edzeery\MyStatusKit;

use Illuminate\Support\Str;

class IconManager
{
    protected array $config;

    public function __construct()
    {
        $this->config = config('status-kit-icons', []);
    }

    /**
     * عرض أيقونة حسب الاسم العام والمجموعة (fa|bi|ion|heroicon|svg).
     * إن كان $name يبدأ بـ "<" يُعتبر HTML جاهز ويُعاد كما هو (توافق مع getIconHtml القديمة).
     */
    public function render(string $name, ?string $set = null, ?string $classes = null): string
    {
        if (Str::startsWith($name, '<')) {
            return $name;
        }

        $set = $set ?: ($this->config['default_set'] ?? 'ion');
        $classes = $classes ?? '';

        if ($set === 'svg') {
            return $this->svg($name, $classes) ?? '';
        }

        if ($set === 'heroicon') {
            return $this->heroicon($name, $classes) ?? '';
        }

        $icons = $this->config[$set] ?? [];
        $icon = $icons[$name] ?? $icons['default'] ?? null;

        if (!$icon) {
            return '';
        }

        if ($set === 'ion') {
            $classAttr = $classes ? " class=\"{$classes}\"" : '';
            return "<ion-icon name=\"{$icon}\"{$classAttr} role=\"img\"></ion-icon>";
        }

        $prefix = $set === 'fa' ? 'fas' : ($set === 'bi' ? 'bi' : '');
        $extra = $classes ? " {$classes}" : '';

        return "<i class=\"{$prefix} {$icon}{$extra}\"></i>";
    }

    /** أيقونة Heroicon كملف SVG مضمّن من resources/svg/heroicons */
    public function heroicon(string $name, string $classes = ''): ?string
    {
        $icons = $this->config['heroicon'] ?? [];
        $fileName = $icons[$name] ?? $icons['default'] ?? $name;

        return $this->svg($fileName, $classes, 'heroicons');
    }

    /** جلب أي ملف SVG من resources/svg (أو مجلد فرعي) وحقن الكلاسات */
    public function svg(string $name, string $classes = '', ?string $subfolder = null): ?string
    {
        $relative = $subfolder ? "{$subfolder}/{$name}.svg" : "{$name}.svg";

        $paths = array_filter([
            resource_path("svg/{$relative}"),                       // ملف منشور في المشروع
            __DIR__ . "/../resources/svg/{$relative}",               // fallback من داخل الحزمة نفسها
        ]);

        $path = collect($paths)->first(fn ($p) => file_exists($p));

        if (!$path) {
            return null;
        }

        $svg = file_get_contents($path);

        if ($classes) {
            $svg = preg_replace('/<svg([^>]*)>/i', '<svg$1 class="' . $classes . '">', $svg, 1);
        }

        return $svg;
    }
}
