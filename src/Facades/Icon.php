<?php

namespace Edzeery\MyStatusKit\Facades;

use Edzeery\MyStatusKit\IconManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string render(string $name, ?string $set = null, ?string $classes = null)
 * @method static string|null svg(string $name, string $classes = '', ?string $subfolder = null)
 * @method static string|null heroicon(string $name, string $classes = '')
 *
 * @see IconManager
 */
class Icon extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'status-kit-icon';
    }
}
