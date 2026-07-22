<?php

namespace Edzeery\MyStatusKit\Casts;

use Edzeery\MyStatusKit\DTO\StatusResult;
use Edzeery\MyStatusKit\Facades\Status;

class StatusCast
{
    public function __construct(
        protected string $domain,
    ) {}

    public function get($model, string $key, $value, array $attributes): ?StatusResult
    {
        if ($value === null) {
            return null;
        }

        return Status::for($this->domain, $value);
    }

    public function set($model, string $key, $value, array $attributes): ?string
    {
        if ($value instanceof StatusResult) {
            return $value->toArray()['status'] ?? null;
        }

        if (is_string($value)) {
            return $value;
        }

        return null;
    }
}
