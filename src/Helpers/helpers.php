<?php

use Edzeery\MyStatusKit\Facades\Icon;
use Edzeery\MyStatusKit\Facades\Status;
use Edzeery\MyStatusKit\Support\AssetsRenderer;

if (!function_exists('status')) {
    /** جلب كائن الحالة الكامل (fluent): status('payment','paid')->color()->icon()... */
    function status(string $domain, string $statusName): \Edzeery\MyStatusKit\DTO\StatusResult
    {
        return Status::for($domain, $statusName);
    }
}

if (!function_exists('status_color')) {
    function status_color(string $domain, string $statusName, bool $withDark = true): string
    {
        return Status::for($domain, $statusName)->color($withDark);
    }
}

if (!function_exists('status_hex')) {
    function status_hex(string $domain, string $statusName): string
    {
        return Status::for($domain, $statusName)->hex();
    }
}

if (!function_exists('status_label')) {
    function status_label(string $domain, string $statusName, ?string $locale = null): string
    {
        return Status::for($domain, $statusName)->label($locale);
    }
}

if (!function_exists('status_icon')) {
    function status_icon(string $domain, string $statusName, ?string $set = null, ?string $classes = null): string
    {
        return Status::for($domain, $statusName)->icon($set, $classes);
    }
}

if (!function_exists('status_badge')) {
    function status_badge(string $domain, string $statusName, ?string $set = null, ?string $extraClasses = null): string
    {
        return Status::for($domain, $statusName)->badge($set, $extraClasses);
    }
}

if (!function_exists('icon')) {
    /** توافق مع الدالة القديمة: icon('paid', 'fa', 'text-lg') */
    function icon(string $name, ?string $set = null, ?string $classes = null): string
    {
        return Icon::render($name, $set, $classes);
    }
}

if (!function_exists('svg_icon')) {
    function svg_icon(string $name, string $classes = ''): ?string
    {
        return Icon::svg($name, $classes);
    }
}

if (!function_exists('getIconHtml')) {
    /** توافق كامل مع الدالة القديمة getIconHtml() */
    function getIconHtml(string $name, ?string $set = null, ?string $classes = null): string
    {
        if (\Illuminate\Support\Str::startsWith($name, '<')) {
            return $name;
        }

        if ($set === 'svg') {
            return Icon::svg($name, $classes ?? '') ?? '';
        }

        return Icon::render($name, $set ?? 'fa', $classes ?? '');
    }
}

if (!function_exists('status_kit_assets')) {
    /** إدراج روابط CDN لمكتبات الأيقونات المطلوبة (بديل عن @statusKitAssets في PHP الخام) */
    function status_kit_assets(array $sets = ['fa', 'bi', 'ion']): string
    {
        return AssetsRenderer::render($sets);
    }
}
