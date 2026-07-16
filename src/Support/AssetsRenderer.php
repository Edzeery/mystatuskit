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
                'fa' => isset($cdn['fa']) ? "<link rel=\"stylesheet\" href=\"{$cdn['fa']}\">" : '',
                'bi' => isset($cdn['bi']) ? "<link rel=\"stylesheet\" href=\"{$cdn['bi']}\">" : '',
                'ion' => isset($cdn['ion'])
                    ? "<script type=\"module\" src=\"{$cdn['ion']}\"></script>"
                    ."<script nomodule src=\"{$cdn['ion_nomodule']}\"></script>"
                    : '',
                default => '',
            };
        }

        return implode("\n", array_filter($html));
    }
}
