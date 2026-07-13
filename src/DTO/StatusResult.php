<?php

namespace Edzeery\MyStatusKit\DTO;

use Edzeery\MyStatusKit\IconManager;

class StatusResult
{
    public function __construct(
        protected string $domain,
        protected string $status,
        protected array $data,
        protected IconManager $iconManager,
    ) {}

    /** اسم عام محايد success|warning|danger|info|gray */
    public function variant(): string
    {
        return $this->data['variant'] ?? 'gray';
    }

    /** كلاسات Tailwind (فاتح + داكن) جاهزة للدمج في class="" */
    public function color(bool $withDark = true): string
    {
        $classes = $this->data['light'] ?? '';
        if ($withDark && !empty($this->data['dark'])) {
            $classes .= ' ' . $this->data['dark'];
        }
        return trim($classes);
    }

    public function lightClass(): string
    {
        return $this->data['light'] ?? '';
    }

    public function darkClass(): string
    {
        return $this->data['dark'] ?? '';
    }

    public function hex(): string
    {
        return $this->data['hex'] ?? '#9ca3af';
    }

    /** التسمية المترجمة حسب اللغة الحالية (lang/{locale}/statuses.php) */
    public function label(?string $locale = null): string
    {
        $key = "statuses.{$this->domain}.{$this->status}";
        $translated = $locale ? __($key, [], $locale) : __($key);

        return $translated === $key
            ? \Illuminate\Support\Str::headline($this->status)
            : $translated;
    }

    /** HTML للأيقونة فقط */
    public function icon(?string $set = null, ?string $classes = null): string
    {
        $iconKey = $this->data['icon'] ?? 'default';
        return $this->iconManager->render($iconKey, $set, $classes);
    }

    /** بادج HTML كامل: أيقونة + تسمية داخل عنصر ملوّن */
    public function badge(?string $set = null, ?string $extraClasses = null): string
    {
        $classes = trim($this->color() . ' ' . ($extraClasses ?? ''));
        $icon = $this->icon($set);
        $label = e($this->label());

        return "<span class=\"status-badge inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium {$classes}\">{$icon}<span>{$label}</span></span>";
    }

    public function toArray(): array
    {
        return [
            'domain'  => $this->domain,
            'status'  => $this->status,
            'variant' => $this->variant(),
            'color'   => $this->color(),
            'hex'     => $this->hex(),
            'label'   => $this->label(),
            'icon'    => $this->data['icon'] ?? 'default',
        ];
    }
}
