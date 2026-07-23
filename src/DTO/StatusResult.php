<?php

namespace Edzeery\MyStatusKit\DTO;

use Edzeery\MyStatusKit\IconManager;
use Illuminate\Support\Str;

class StatusResult implements \JsonSerializable
{
    public const FALLBACK = [
        'variant' => 'gray',
        'light' => 'text-gray-700 bg-gray-100',
        'dark' => 'dark:text-gray-300 dark:bg-gray-800',
        'hex' => '#9ca3af',
        'icon' => 'default',
    ];

    /** @var array|null كاش لبيانات الحالة بعد الحل (يمنع استدعاء config عدة مرات) */
    private ?array $resolvedCache = null;

    public function __construct(
        protected string $domain,
        protected string $status,
        protected array|string $data,
        protected IconManager $iconManager,
    ) {}

    public function __toString(): string
    {
        return $this->label();
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /** اسم عام محايد success|warning|danger|info|gray */
    public function variant(): string
    {
        return $this->resolvedData()['variant'] ?? 'gray';
    }

    /**
     * كلاسات الألوان جاهزة للدمج في class="".
     *
     * $framework: 'bootstrap' | 'tailwind' | null (يستعمل config('status-kit-theme.default_framework'))
     */
    public function color(bool $withDark = true, ?string $framework = null): string
    {
        $framework = $framework ?? config('status-kit-theme.default_framework', 'bootstrap');

        if ($framework === 'bootstrap') {
            $map = config('status-kit-theme.bootstrap_variants', []);

            return $map[$this->variant()] ?? $map['gray'] ?? 'text-bg-secondary';
        }

        $data = $this->resolvedData();
        $classes = $data['light'] ?? '';
        if ($withDark && ! empty($data['dark'])) {
            $classes .= ' '.$data['dark'];
        }

        return trim($classes);
    }

    /** كلاسات Tailwind الفاتحة فقط */
    public function lightClass(): string
    {
        return $this->resolvedData()['light'] ?? '';
    }

    /** كلاسات Tailwind الداكنة فقط */
    public function darkClass(): string
    {
        return $this->resolvedData()['dark'] ?? '';
    }

    public function hex(): string
    {
        $hex = $this->resolvedData()['hex'] ?? '#9ca3af';

        return preg_match('/^#[0-9a-fA-F]{6}$/', $hex) ? $hex : '#9ca3af';
    }

    /** هل هذه الحالة مطابقة لاسم معين؟ */
    public function is(string $status): bool
    {
        return $this->status === $status;
    }

    /** هل هذه الحالة في قائمة محددة؟ */
    public function isOneOf(array $statuses): bool
    {
        return in_array($this->status, $statuses, true);
    }

    /** هل هذه الحالة تنتمي لنطاق معين؟ */
    public function inDomain(string $domain): bool
    {
        return $this->domain === $domain;
    }

    /**
     * التسمية المترجمة حسب اللغة الحالية.
     */
    public function label(?string $locale = null): string
    {
        $key = "status-kit::statuses.{$this->domain}.{$this->status}";
        $translated = $locale ? __($key, [], $locale) : __($key);

        return $translated === $key
            ? Str::headline($this->status)
            : $translated;
    }

    /** HTML للأيقونة فقط */
    public function icon(?string $set = null, ?string $classes = null): string
    {
        $iconKey = $this->resolvedData()['icon'] ?? 'default';

        return $this->iconManager->render($iconKey, $set, $classes);
    }

    /**
     * كلاسات عنصر البادج كاملة (أساس الفريموورك + لون + إضافات).
     */
    public function badgeClasses(?string $extraClasses = null, ?string $framework = null): string
    {
        $framework = $framework ?? config('status-kit-theme.default_framework', 'bootstrap');
        $base = config("status-kit-theme.badge_base.{$framework}", '');

        return trim($base.' '.$this->color(true, $framework).' '.($extraClasses ?? ''));
    }

    /** بادج HTML كامل: أيقونة + تسمية داخل عنصر ملوّن */
    public function badge(?string $set = null, ?string $extraClasses = null, ?string $framework = null): string
    {
        $classes = $this->badgeClasses($extraClasses, $framework);
        $icon = $this->icon($set);
        $label = e($this->label());

        return "<span class=\"{$classes}\">{$icon}<span>{$label}</span></span>";
    }

    /** بادج بلا أيقونة — نص + ألوان فقط */
    public function badgeWithoutIcon(?string $extraClasses = null, ?string $framework = null): string
    {
        $classes = $this->badgeClasses($extraClasses, $framework);
        $label = e($this->label());

        return "<span class=\"{$classes}\"><span>{$label}</span></span>";
    }

    /** أيقونة فقط — بلا نص وبلا خلفية بادج */
    public function iconOnly(?string $set = null, ?string $classes = null): string
    {
        return $this->icon($set, $classes);
    }

    public function toArray(): array
    {
        $data = $this->resolvedData();

        return [
            'domain' => $this->domain,
            'status' => $this->status,
            'variant' => $this->variant(),
            'color' => $this->color(),
            'hex' => $this->hex(),
            'label' => $this->label(),
            'icon' => $data['icon'] ?? 'default',
        ];
    }

    /**
     * إرجاع البيانات كمصفوفة مُحلّاة (يحل مشكلة string data من _shared).
     * النتيجة مُخزّنة مؤقتاً لتقليل استدعاءات config().
     */
    private function resolvedData(): array
    {
        if ($this->resolvedCache !== null) {
            return $this->resolvedCache;
        }

        if (is_array($this->data)) {
            return $this->resolvedCache = $this->data;
        }

        // data = string (اسم من _shared)
        return $this->resolvedCache = config("status-kit-statuses._shared.{$this->data}", self::FALLBACK);
    }
}
