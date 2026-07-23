<?php

namespace Edzeery\MyStatusKit\Facades;

use Edzeery\MyStatusKit\StatusManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Edzeery\MyStatusKit\DTO\StatusResult for(string $domain, string $status)
 * @method static array domain(string $domain)
 * @method static array domains()
 * @method static bool exists(string $domain, string $status)
 * @method static void register(string $domain, string $status, array $data)
 * @method static void registerMany(string $domain, array $statuses)
 *
 * @see StatusManager
 */
class Status extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'status-kit';
    }
}
