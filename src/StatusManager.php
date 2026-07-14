<?php

namespace Edzeery\MyStatusKit;

use InvalidArgumentException;
use Edzeery\MyStatusKit\DTO\StatusResult;

class StatusManager
{
    public function __construct(protected IconManager $iconManager) {}

    /**
     * جلب حالة من نطاق معيّن.
     *
     * @throws InvalidArgumentException إذا لم توجد الحالة ولا توجد قيمة افتراضية
     */
    public function for(string $domain, string $status): StatusResult
    {
        $data = config("status-kit-statuses.{$domain}.{$status}");

        if ($data === null) {
            $data = config("status-kit-statuses.general.gray", [
                'variant' => 'gray', 'light' => 'text-gray-700 bg-gray-100',
                'dark' => 'dark:text-gray-300 dark:bg-gray-800', 'hex' => '#9ca3af', 'icon' => 'default',
            ]);
        }

        return new StatusResult($domain, $status, $data, $this->iconManager);
    }

    /** كل حالات نطاق معيّن، جاهزة كـ StatusResult (مفيد لبناء select/legend) */
    public function domain(string $domain): array
    {
        $items = config("status-kit-statuses.{$domain}", []);
        $result = [];

        foreach ($items as $status => $data) {
            $result[$status] = new StatusResult($domain, $status, $data, $this->iconManager);
        }

        return $result;
    }

    /** هل الحالة معرّفة أصلاً في الconfig */
    public function exists(string $domain, string $status): bool
    {
        return config("status-kit-statuses.{$domain}.{$status}") !== null;
    }
}
