<?php

namespace Edzeery\MyStatusKit;

use Edzeery\MyStatusKit\DTO\StatusResult;

class StatusManager
{
    public function __construct(protected IconManager $iconManager) {}

    /**
     * Retrieve a status result for a given domain and status name.
     *
     * Supports the _shared resolution system:
     *   - string value: inherits full definition from _shared
     *   - array without 'variant': partially merged with _shared
     *   - array with 'variant': standalone domain-specific definition
     *
     * Falls back to the default status (_shared.default) when not found.
     *
     * @param  string  $domain  The domain name (e.g. 'payment', 'order').
     * @param  string  $status  The status key within the domain (e.g. 'paid', 'pending').
     */
    public function for(string $domain, string $status): StatusResult
    {
        $data = $this->resolveData($domain, $status);

        return new StatusResult($domain, $status, $data, $this->iconManager);
    }

    /**
     * Get all statuses within a domain as StatusResult instances.
     *
     * Useful for building select dropdowns, legends, or status listings.
     *
     * @param  string  $domain  The domain name to retrieve statuses for.
     * @return array<string, StatusResult>
     */
    public function domain(string $domain): array
    {
        $items = config("status-kit-statuses.{$domain}", []);
        $result = [];

        foreach ($items as $status => $data) {
            if (! is_string($status)) {
                continue;
            }

            $resolved = $this->resolveData($domain, $status);
            $result[$status] = new StatusResult($domain, $status, $resolved, $this->iconManager);
        }

        return $result;
    }

    /**
     * Get a list of all defined domain names (excluding _shared).
     *
     * @return array<int, string>
     */
    public function domains(): array
    {
        $all = config('status-kit-statuses', []);

        return array_values(array_diff(array_keys($all), ['_shared']));
    }

    /**
     * Check whether a status is defined in the configuration.
     *
     * @param  string  $domain  The domain name.
     * @param  string  $status  The status key.
     */
    public function exists(string $domain, string $status): bool
    {
        return config("status-kit-statuses.{$domain}.{$status}") !== null;
    }

    /**
     * Register a new status at runtime without publishing a config file.
     *
     * @param  string  $domain  The domain to register the status under.
     * @param  string  $status  The status key name.
     * @param  array  $data  Status definition array (variant, hex, icon, light, dark, etc.).
     */
    public function register(string $domain, string $status, array $data): void
    {
        $existing = config("status-kit-statuses.{$domain}", []);
        $existing[$status] = $data;

        config(["status-kit-statuses.{$domain}" => $existing]);
    }

    /**
     * Register multiple statuses under a single domain at once.
     *
     * @param  string  $domain  The domain to register statuses under.
     * @param  array  $statuses  Associative array of status key => definition pairs.
     */
    public function registerMany(string $domain, array $statuses): void
    {
        foreach ($statuses as $status => $data) {
            $this->register($domain, $status, $data);
        }
    }

    /**
     * حل بيانات الحالة: string → _shared، array جزئي → دمج مع _shared.
     */
    private function resolveData(string $domain, string $status): array
    {
        $data = config("status-kit-statuses.{$domain}.{$status}");

        // الحالة مشروحة من _shared كـ string
        if (is_string($data)) {
            $shared = config("status-kit-statuses._shared.{$data}", []);

            return ! empty($shared) ? $shared : $this->fallback();
        }

        // الحالة array مع تعديلات جزئية → تدمج مع _shared
        if (is_array($data) && $this->isPartialOverride($data)) {
            $shared = config("status-kit-statuses._shared.{$status}", []);

            return array_merge($shared, $data);
        }

        // fallback
        if ($data === null || $data === []) {
            return $this->fallback();
        }

        return $data;
    }

    /**
     * هل هذا تعديل جزئي فقط (مثل ['icon' => 'paid'])؟
     *
     * تُconsider جزئية إذا كانت array لا تحتوي مفتاح 'variant' —
     * لأن 'variant' هو الحقل الأساسي الذي يميّز تعريف الحالة الكامل.
     */
    private function isPartialOverride(array $data): bool
    {
        return ! array_key_exists('variant', $data);
    }

    private function fallback(): array
    {
        return config('status-kit-statuses._shared.default', StatusResult::FALLBACK);
    }
}
