<?php

namespace Edzeery\MyStatusKit\Tests;

use Edzeery\MyStatusKit\StatusManager;
use Edzeery\MyStatusKit\IconManager;

class ServiceProviderTest extends TestCase
{
    public function test_status_manager_is_registered(): void
    {
        $manager = app(StatusManager::class);

        $this->assertInstanceOf(StatusManager::class, $manager);
    }

    public function test_icon_manager_is_registered(): void
    {
        $manager = app(IconManager::class);

        $this->assertInstanceOf(IconManager::class, $manager);
    }

    public function test_singleton_returns_same_instance(): void
    {
        $first = app(StatusManager::class);
        $second = app(StatusManager::class);

        $this->assertSame($first, $second);
    }

    public function test_config_is_merged(): void
    {
        $this->assertNotNull(config('status-kit-statuses'));
        $this->assertNotNull(config('status-kit-icons'));
        $this->assertNotNull(config('status-kit-theme'));
    }

    public function test_config_has_payment_domain(): void
    {
        $payment = config('status-kit-statuses.payment');

        $this->assertNotNull($payment);
        $this->assertArrayHasKey('paid', $payment);
    }

    public function test_config_has_default_framework(): void
    {
        $framework = config('status-kit-theme.default_framework');

        $this->assertNotNull($framework);
        $this->assertContains($framework, ['bootstrap', 'tailwind']);
    }

    public function test_config_has_default_icon_set(): void
    {
        $defaultSet = config('status-kit-icons.default_set');

        $this->assertNotNull($defaultSet);
        $this->assertContains($defaultSet, ['fa', 'bi', 'ion', 'heroicon', 'svg']);
    }

    public function test_blade_directives_registered(): void
    {
        $blade = app('blade.compiler');
        $compiled = $blade->compileString('@statusKitAssets(["fa"])');
        $this->assertIsString($compiled);
    }

    public function test_translations_are_loaded(): void
    {
        $label = __('status-kit::statuses.payment.paid');

        $this->assertNotEmpty($label);
        $this->assertNotEquals('status-kit::statuses.payment.paid', $label);
    }

    public function test_facade_accessors_work(): void
    {
        $status = \Edzeery\MyStatusKit\Facades\Status::for('payment', 'paid');
        $this->assertInstanceOf(\Edzeery\MyStatusKit\DTO\StatusResult::class, $status);

        $html = \Edzeery\MyStatusKit\Facades\Icon::render('paid', 'bi');
        $this->assertIsString($html);
    }
}
