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

    /**
     * كلاسات الألوان جاهزة للدمج في class="".
     *
     * $framework: 'bootstrap' | 'tailwind' | null (يستعمل config('status-kit-theme.default_framework'))
     * - bootstrap : كلاس واحد مبني من variant عبر config/theme.php (text-bg-success...). $withDark بلا تأثير هنا.
     * - tailwind  : كلاسات light/dark اليدوية الموجودة في statuses.php (السلوك القديم قبل v1.0.2).
     */
    public function color(bool $withDark = true, ?string $framework = null): string
    {
        $framework = $framework ?? config('status-kit-theme.default_framework', 'bootstrap');

        if ($framework === 'bootstrap') {
            $map = config('status-kit-theme.bootstrap_variants', []);

            return $map[$this->variant()] ?? $map['gray'] ?? 'text-bg-secondary';
        }

        $classes = $this->data['light'] ?? '';
        if ($withDark && !empty($this->data['dark'])) {
            $classes .= ' ' . $this->data['dark'];
        }

        return trim($classes);
    }

    /** كلاسات Tailwind الفاتحة فقط (متوفرة دومًا بغض النظر عن الframework المختار) */
    public function lightClass(): string
    {
        return $this->data['light'] ?? '';
    }

    /** كلاسات Tailwind الداكنة فقط (متوفرة دومًا بغض النظر عن الframework المختار) */
    public function darkClass(): string
    {
        return $this->data['dark'] ?? '';
    }

    public function hex(): string
    {
        return $this->data['hex'] ?? '#9ca3af';
    }

    /**
     * التسمية المترجمة حسب اللغة الحالية.
     * تقرأ من ملفات الحزمة نفسها (lang/{locale}/statuses.php) عبر namespace "status-kit"،
     * أو من resources/lang/vendor/status-kit/{locale}/statuses.php إذا نُشرت ونُخصصت في المشروع.
     */
    public function label(?string $locale = null): string
    {
        $key = "status-kit::statuses.{$this->domain}.{$this->status}";
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

    /**
     * كلاسات عنصر البادج كاملة (أساس الفريموورك + لون + إضافات)، جاهزة للدمج في class="".
     * يستعملها badge() وأيضًا <x-status-badge> لتفادي تكرار المنطق.
     */
    public function badgeClasses(?string $extraClasses = null, ?string $framework = null): string
    {
        $framework = $framework ?? config('status-kit-theme.default_framework', 'bootstrap');
        $base = config("status-kit-theme.badge_base.{$framework}", '');

        return trim($base . ' ' . $this->color(true, $framework) . ' ' . ($extraClasses ?? ''));
    }

    /** بادج HTML كامل: أيقونة + تسمية داخل عنصر ملوّن */
    public function badge(?string $set = null, ?string $extraClasses = null, ?string $framework = null): string
    {
        $classes = $this->badgeClasses($extraClasses, $framework);
        $icon = $this->icon($set);
        $label = e($this->label());

        return "<span class=\"{$classes}\">{$icon}<span>{$label}</span></span>";
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
