<?php

namespace Edzeery\MyStatusKit\Casts;

use Edzeery\MyStatusKit\DTO\StatusResult;
use Edzeery\MyStatusKit\Facades\Status;
use Illuminate\Database\Eloquent\Model;

class StatusCast
{
    public function __construct(
        protected string $domain,
    ) {}

    public function get(Model $model, string $key, mixed $value, array $attributes): ?StatusResult
    {
        if ($value === null) {
            return null;
        }

        return Status::for($this->domain, (string) $value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value instanceof StatusResult) {
            return $value->toArray()['status'] ?? null;
        }

        if (is_scalar($value)) {
            return (string) $value;
        }

        return null;
    }
}
