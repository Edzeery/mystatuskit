<?php

namespace Edzeery\MyStatusKit\Tests;

use Edzeery\MyStatusKit\StatusManager;
use Edzeery\MyStatusKit\DTO\StatusResult;

class StatusManagerTest extends TestCase
{
    private StatusManager $manager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->manager = app(StatusManager::class);
    }

    public function test_for_returns_status_result_for_valid_status(): void
    {
        $result = $this->manager->for('payment', 'paid');

        $this->assertInstanceOf(StatusResult::class, $result);
        $this->assertEquals('payment', $result->toArray()['domain']);
        $this->assertEquals('paid', $result->toArray()['status']);
    }

    public function test_for_returns_default_gray_for_unknown_status(): void
    {
        $result = $this->manager->for('payment', 'nonexistent');

        $this->assertInstanceOf(StatusResult::class, $result);
        $this->assertEquals('gray', $result->variant());
        $this->assertEquals('#9ca3af', $result->hex());
    }

    public function test_for_returns_default_gray_for_unknown_domain(): void
    {
        $result = $this->manager->for('nonexistent', 'anything');

        $this->assertInstanceOf(StatusResult::class, $result);
        $this->assertEquals('gray', $result->variant());
    }

    public function test_domain_returns_all_statuses(): void
    {
        $results = $this->manager->domain('payment');

        $this->assertIsArray($results);
        $this->assertArrayHasKey('paid', $results);
        $this->assertArrayHasKey('pending', $results);
        $this->assertArrayHasKey('failed', $results);
        $this->assertArrayHasKey('completed', $results);
        $this->assertArrayHasKey('refunded', $results);
        $this->assertArrayHasKey('canceled', $results);

        foreach ($results as $result) {
            $this->assertInstanceOf(StatusResult::class, $result);
        }
    }

    public function test_domain_returns_empty_array_for_unknown_domain(): void
    {
        $results = $this->manager->domain('nonexistent');

        $this->assertIsArray($results);
        $this->assertEmpty($results);
    }

    public function test_exists_returns_true_for_valid_status(): void
    {
        $this->assertTrue($this->manager->exists('payment', 'paid'));
    }

    public function test_exists_returns_false_for_invalid_status(): void
    {
        $this->assertFalse($this->manager->exists('payment', 'nonexistent'));
    }

    public function test_exists_returns_false_for_invalid_domain(): void
    {
        $this->assertFalse($this->manager->exists('nonexistent', 'paid'));
    }

    public function test_for_works_for_all_domains(): void
    {
        $domains = ['payment', 'subscription', 'user', 'stores', 'order', 'product', 'role', 'invoice', 'notification', 'general'];

        foreach ($domains as $domain) {
            $results = $this->manager->domain($domain);
            $this->assertNotEmpty($results, "Domain '{$domain}' should have at least one status");
        }
    }

    public function test_facade_works(): void
    {
        $result = \Edzeery\MyStatusKit\Facades\Status::for('payment', 'paid');

        $this->assertInstanceOf(StatusResult::class, $result);
        $this->assertEquals('paid', $result->toArray()['status']);
    }
}
