<?php

namespace Edzeery\MyStatusKit\Tests;

use Edzeery\MyStatusKit\Casts\StatusCast;
use Edzeery\MyStatusKit\DTO\StatusResult;
use Edzeery\MyStatusKit\Facades\Status;
use Illuminate\Database\Eloquent\Model;

class StatusCastTest extends TestCase
{
    public function test_get_returns_status_result_for_valid_status(): void
    {
        $cast = new StatusCast('payment');
        $model = new class extends Model {};

        $result = $cast->get($model, 'status', 'paid', []);
        $this->assertInstanceOf(StatusResult::class, $result);
        $this->assertEquals('paid', $result->toArray()['status']);
    }

    public function test_get_returns_null_for_null_value(): void
    {
        $cast = new StatusCast('payment');
        $model = new class extends Model {};

        $result = $cast->get($model, 'status', null, []);
        $this->assertNull($result);
    }

    public function test_get_casts_non_string_to_string(): void
    {
        $cast = new StatusCast('payment');
        $model = new class extends Model {};

        $result = $cast->get($model, 'status', 123, []);
        // 123 cast to '123' — unknown status, should get fallback
        $this->assertInstanceOf(StatusResult::class, $result);
    }

    public function test_set_with_status_result_returns_status_string(): void
    {
        $cast = new StatusCast('payment');
        $model = new class extends Model {};
        $statusResult = Status::for('payment', 'paid');

        $value = $cast->set($model, 'status', $statusResult, []);
        $this->assertEquals('paid', $value);
    }

    public function test_set_with_string_returns_same_string(): void
    {
        $cast = new StatusCast('payment');
        $model = new class extends Model {};

        $value = $cast->set($model, 'status', 'pending', []);
        $this->assertEquals('pending', $value);
    }

    public function test_set_with_int_returns_casted_string(): void
    {
        $cast = new StatusCast('payment');
        $model = new class extends Model {};

        $value = $cast->set($model, 'status', 42, []);
        $this->assertEquals('42', $value);
    }

    public function test_set_with_array_returns_null(): void
    {
        $cast = new StatusCast('payment');
        $model = new class extends Model {};

        $value = $cast->set($model, 'status', ['invalid'], []);
        $this->assertNull($value);
    }

    public function test_set_with_null_returns_null(): void
    {
        $cast = new StatusCast('payment');
        $model = new class extends Model {};

        $value = $cast->set($model, 'status', null, []);
        $this->assertNull($value);
    }
}
