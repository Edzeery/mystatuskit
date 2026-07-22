<?php

namespace Edzeery\MyStatusKit\Support;

class AssetsRenderer
{
    /**
     * يُرجع وسوم <link>/<script> اللازمة لمكتبات الأيقونات المطلوبة عبر CDN.
     * الاستعمال في Blade: @statusKitAssets(['fa', 'bi', 'ion'])
     * أو عبر الدالة المساعدة: status_kit_assets(['fa'])
     *
     * ملاحظة: هذا حل سريع (CDN) يعمل مباشرة بدون تثبيت.
     * للاستضافة المحلية / npm راجع README.md قسم "تثبيت مكتبات الأيقونات".
     */
    public static function render(array $sets = ['fa', 'bi', 'ion']): string
    {
        $cdn = config('status-kit-icons.cdn', []);
        $html = [];

        foreach ($sets as $set) {
            $html[] = match ($set) {
                'fa' => self::renderLink($cdn['fa'] ?? null),
                'bi' => self::renderLink($cdn['bi'] ?? null),
                'ion' => self::renderIonicons($cdn),
                default => '',
            };
        }

        return implode("\n", array_filter($html));
    }

    /**
     * توليد وسم <link> مع دعم SRI (integrity + crossorigin).
     * يدعم القديم (string URL) والجديد (array مع url/integrity/crossorigin).
     */
    private static function renderLink(string|array|null $cdn): string
    {
        if (is_null($cdn)) {
            return '';
        }

        if (is_string($cdn)) {
            return "<link rel=\"stylesheet\" href=\"{$cdn}\">";
        }

        $url = $cdn['url'] ?? '';
        if (! $url) {
            return '';
        }

        $integrity = $cdn['integrity'] ?? null;
        $crossorigin = $cdn['crossorigin'] ?? 'anonymous';

        $attrs = "rel=\"stylesheet\" href=\"{$url}\"";
        if ($integrity) {
            $attrs .= " integrity=\"{$integrity}\" crossorigin=\"{$crossorigin}\"";
        }

        return "<link {$attrs}>";
    }

    /**
     * توليد وسوم Ionicons <script> مع دعم SRI.
     */
    private static function renderIonicons(array $cdn): string
    {
        $parts = [];

        $esm = $cdn['ion'] ?? null;
        $nomodule = $cdn['ion_nomodule'] ?? null;

        if ($esm) {
            $url = is_array($esm) ? ($esm['url'] ?? '') : $esm;
            $integrity = is_array($esm) ? ($esm['integrity'] ?? null) : null;
            $crossorigin = is_array($esm) ? ($esm['crossorigin'] ?? 'anonymous') : 'anonymous';

            $attrs = "type=\"module\" src=\"{$url}\"";
            if ($integrity) {
                $attrs .= " integrity=\"{$integrity}\" crossorigin=\"{$crossorigin}\"";
            }
            $parts[] = "<script {$attrs}></script>";
        }

        if ($nomodule) {
            $url = is_array($nomodule) ? ($nomodule['url'] ?? '') : $nomodule;
            $integrity = is_array($nomodule) ? ($nomodule['integrity'] ?? null) : null;
            $crossorigin = is_array($nomodule) ? ($nomodule['crossorigin'] ?? 'anonymous') : 'anonymous';

            $attrs = "nomodule src=\"{$url}\"";
            if ($integrity) {
                $attrs .= " integrity=\"{$integrity}\" crossorigin=\"{$crossorigin}\"";
            }
            $parts[] = "<script {$attrs}></script>";
        }

        return implode("\n", $parts);
    }
}
