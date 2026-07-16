<?php

namespace Edzeery\MyStatusKit;

use Edzeery\MyStatusKit\DTO\StatusResult;

class StatusManager
{
    public function __construct(protected IconManager $iconManager) {}

    /**
     * جلب حالة من نطاق معيّن.
     *
     * يدعم نظام _shared:
     *   - string: يأخذ من _shared بالكامل
     *   - array مع icon فقط: يدمج مع _shared
     *   - array كامل: حالة خاصة بالنطاق
     *
     * إذا لم توجد الحالة، تُرجع الحالة الافتراضية (_shared.default).
     */
    public function for(string $domain, string $status): StatusResult
    {
        $data = config("status-kit-statuses.{$domain}.{$status}");

        // الحالة مشروحة من _shared كـ string
        if (is_string($data)) {
            $shared = config("status-kit-statuses._shared.{$data}", []);
            $data = ! empty($shared) ? $shared : $this->fallback();
        }

        // الحالة array مع تعديلات بسيطة (icon مثلاً) → تدمج مع _shared
        if (is_array($data) && $this->isPartialOverride($data)) {
            $shared = config("status-kit-statuses._shared.{$status}", []);
            $data = array_merge($shared, $data);
        }

        // fallback
        if ($data === null || $data === []) {
            $data = $this->fallback();
        }

        return new StatusResult($domain, $status, $data, $this->iconManager);
    }

    /** كل حالات نطاق معيّن، جاهزة كـ StatusResult (مفيد لبناء select/legend) */
    public function domain(string $domain): array
    {
        $items = config("status-kit-statuses.{$domain}", []);
        $result = [];

        foreach ($items as $status => $data) {
            if (! is_string($status)) {
                continue;
            }

            // حل حالات _shared (string أو array جزئي)
            if (is_string($data)) {
                $shared = config("status-kit-statuses._shared.{$data}", []);
                $data = ! empty($shared) ? $shared : $this->fallback();
            } elseif (is_array($data) && $this->isPartialOverride($data)) {
                $shared = config("status-kit-statuses._shared.{$status}", []);
                $data = array_merge($shared, $data);
            }

            $result[$status] = new StatusResult($domain, $status, $data, $this->iconManager);
        }

        return $result;
    }

    /** هل الحالة معرّفة أصلاً في الconfig */
    public function exists(string $domain, string $status): bool
    {
        return config("status-kit-statuses.{$domain}.{$status}") !== null;
    }

    /**
     * هل هذا تعديل جزئي فقط (مثل ['icon' => 'paid'])؟
     * الحالة تُconsider جزئية إذا كانت array وكل قيمها string (أيقونات فقط).
     */
    private function isPartialOverride(array $data): bool
    {
        if (empty($data)) {
            return true;
        }

        foreach ($data as $key => $value) {
            if (! is_string($value)) {
                return false;
            }
        }

        return true;
    }

    private function fallback(): array
    {
        return config('status-kit-statuses._shared.default', [
            'variant' => 'gray',
            'light' => 'text-gray-700 bg-gray-100',
            'dark' => 'dark:text-gray-300 dark:bg-gray-800',
            'hex' => '#9ca3af',
            'icon' => 'default',
        ]);
    }
}
