<?php

namespace Edzeery\MyStatusKit;

use Illuminate\Support\Str;

class IconManager
{
    protected array $config;

    /** @var array<string, string> Cache in-memory لمحتوى ملفات SVG لتقليل قراءات القرص */
    private array $svgCache = [];

    public function __construct()
    {
        $this->config = config('status-kit-icons', []);
    }

    /**
     * Render an icon by name and set (fa|bi|ion|heroicon|svg).
     *
     * If $name starts with "<" it is treated as raw HTML and returned as-is.
     * ⚠️ Raw HTML bypasses sanitization — ensure $name contains no untrusted user input.
     *
     * @param  string  $name  The icon name or raw HTML string.
     * @param  string|null  $set  Icon set: 'fa', 'bi', 'ion', 'heroicon', 'svg'. Uses config default if null.
     * @param  string|null  $classes  Optional CSS classes to append.
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

        if (! $icon) {
            return '';
        }

        $escapedClasses = $classes ? e($classes) : '';

        if ($set === 'ion') {
            $classAttr = $escapedClasses ? " class=\"{$escapedClasses}\"" : '';

            return "<ion-icon name=\"{$icon}\"{$classAttr} role=\"img\"></ion-icon>";
        }

        $prefix = $set === 'fa' ? 'fas' : ($set === 'bi' ? 'bi' : '');
        $extra = $escapedClasses ? " {$escapedClasses}" : '';

        return "<i class=\"{$prefix} {$icon}{$extra}\"></i>";
    }

    /**
     * Render a Heroicon as an inline SVG from resources/svg/heroicons.
     *
     * @param  string  $name  The heroicon name (e.g. 'check-circle').
     * @param  string  $classes  Optional CSS classes to inject into the SVG element.
     * @return string|null The SVG markup, or null if the file was not found.
     */
    public function heroicon(string $name, string $classes = ''): ?string
    {
        $icons = $this->config['heroicon'] ?? [];
        $fileName = $icons[$name] ?? $icons['default'] ?? $name;

        return $this->svg($fileName, $classes, 'heroicons');
    }

    /**
     * Load an SVG file from resources/svg (or a subfolder) and inject CSS classes.
     *
     * Results are cached in memory to avoid repeated disk reads.
     *
     * @param  string  $name  The SVG file name (without .svg extension).
     * @param  string  $classes  Optional CSS classes to inject into the SVG element.
     * @param  string|null  $subfolder  Optional subfolder within resources/svg (e.g. 'heroicons').
     * @return string|null The sanitized SVG markup, or null if the file was not found.
     */
    public function svg(string $name, string $classes = '', ?string $subfolder = null): ?string
    {
        $relative = $subfolder ? "{$subfolder}/{$name}.svg" : "{$name}.svg";

        // استخدم الكاش إن وُجد
        if (isset($this->svgCache[$relative])) {
            return $this->injectSvgAttributes($this->svgCache[$relative], $classes);
        }

        $paths = array_filter([
            resource_path("svg/{$relative}"),
            __DIR__."/../resources/svg/{$relative}",
        ]);

        $path = collect($paths)->first(fn ($p) => file_exists($p));

        if (! $path) {
            return null;
        }

        $svg = file_get_contents($path);

        // تنقية SVG: إزالة أي عناصر script أو event handlers
        $svg = $this->sanitizeSvg($svg);

        // تخزين في الكاش
        $this->svgCache[$relative] = $svg;

        return $this->injectSvgAttributes($svg, $classes);
    }

    /**
     * حقن عناصر width/height و class في SVG (منفصل عن القراءة للاستفادة من الكاش).
     */
    private function injectSvgAttributes(string $svg, string $classes): string
    {
        if (! preg_match('/\swidth\s*=/i', $svg)) {
            $defaultSize = config('status-kit-icons.svg_size', '1em');
            $svg = preg_replace('/<svg/i', '<svg width="'.$defaultSize.'" height="'.$defaultSize.'"', $svg, 1);
        }

        if ($classes) {
            $escapedClasses = e($classes);
            $svg = preg_replace('/<svg([^>]*)>/i', '<svg$1 class="'.$escapedClasses.'">', $svg, 1);
        }

        return $svg;
    }

    /**
     * تنقية SVG أساسية: إزالة عناصر script و event handlers.
     */
    private function sanitizeSvg(string $svg): string
    {
        // إزالة عناصر <script> و </script> ومحتواها
        $svg = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $svg);

        // إزالة on* event handlers (onclick, onload, onerror, إلخ)
        $svg = preg_replace('/\s+on\w+\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $svg);

        return $svg;
    }
}
