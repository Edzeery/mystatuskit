<?php

namespace Edzeery\MyStatusKit\Tests;

use Edzeery\MyStatusKit\Facades\Status;

class AdvancedTest extends TestCase
{
    // --- StatusResult new methods ---

    public function test_is_returns_true_for_matching_status(): void
    {
        $result = Status::for('payment', 'paid');
        $this->assertTrue($result->is('paid'));
    }

    public function test_is_returns_false_for_non_matching_status(): void
    {
        $result = Status::for('payment', 'paid');
        $this->assertFalse($result->is('failed'));
    }

    public function test_is_one_of_returns_true(): void
    {
        $result = Status::for('payment', 'paid');
        $this->assertTrue($result->isOneOf(['paid', 'pending']));
    }

    public function test_is_one_of_returns_false(): void
    {
        $result = Status::for('payment', 'paid');
        $this->assertFalse($result->isOneOf(['failed', 'canceled']));
    }

    public function test_in_domain_returns_true(): void
    {
        $result = Status::for('payment', 'paid');
        $this->assertTrue($result->inDomain('payment'));
    }

    public function test_in_domain_returns_false(): void
    {
        $result = Status::for('payment', 'paid');
        $this->assertFalse($result->inDomain('order'));
    }

    public function test_to_string_returns_label(): void
    {
        $result = Status::for('payment', 'paid');
        $this->assertEquals($result->label(), (string) $result);
    }

    public function test_json_serializable(): void
    {
        $result = Status::for('payment', 'paid');
        $json = json_encode($result);
        $this->assertIsString($json);
        $this->assertStringContainsString('"domain":"payment"', $json);
        $this->assertStringContainsString('"status":"paid"', $json);
        $decoded = json_decode($json, true);
        $this->assertEquals('payment', $decoded['domain']);
        $this->assertEquals('paid', $decoded['status']);
    }

    // --- StatusManager::domains() ---

    public function test_domains_returns_array(): void
    {
        $domains = Status::domains();
        $this->assertIsArray($domains);
        $this->assertContains('payment', $domains);
        $this->assertContains('order', $domains);
        $this->assertContains('user', $domains);
    }

    public function test_domains_excludes_shared(): void
    {
        $domains = Status::domains();
        $this->assertNotContains('_shared', $domains);
    }

    // --- StatusManager::exists() ---

    public function test_exists_returns_true_for_known(): void
    {
        $this->assertTrue(Status::exists('payment', 'paid'));
    }

    public function test_exists_returns_false_for_unknown(): void
    {
        $this->assertFalse(Status::exists('payment', 'nonexistent'));
    }

    public function test_exists_returns_false_for_unknown_domain(): void
    {
        $this->assertFalse(Status::exists('nonexistent_domain', 'paid'));
    }

    // --- StatusManager::register() ---

    public function test_register_adds_new_status(): void
    {
        Status::register('custom_domain', 'urgent', [
            'variant' => 'danger',
            'hex' => '#ff0000',
            'icon' => 'warning',
        ]);

        $result = Status::for('custom_domain', 'urgent');
        $this->assertEquals('danger', $result->variant());
        $this->assertEquals('#ff0000', $result->hex());
    }

    public function test_register_many_adds_multiple(): void
    {
        Status::registerMany('bulk_domain', [
            'ok' => ['variant' => 'success', 'hex' => '#00ff00', 'icon' => 'check'],
            'nok' => ['variant' => 'danger', 'hex' => '#ff0000', 'icon' => 'cross'],
        ]);

        $this->assertEquals('success', Status::for('bulk_domain', 'ok')->variant());
        $this->assertEquals('danger', Status::for('bulk_domain', 'nok')->variant());
    }

    // --- Helpers ---

    public function test_status_exists_helper(): void
    {
        $this->assertTrue(status_exists('payment', 'paid'));
        $this->assertFalse(status_exists('payment', 'nonexistent'));
    }

    public function test_status_domain_helper(): void
    {
        $items = status_domain('payment');
        $this->assertIsArray($items);
        $this->assertArrayHasKey('paid', $items);
    }

    public function test_status_domains_helper(): void
    {
        $domains = status_domains();
        $this->assertIsArray($domains);
        $this->assertContains('payment', $domains);
    }

    // --- Partial override with variant key ---

    public function test_partial_override_without_shared_entry_returns_fallback(): void
    {
        $result = Status::for('payment', 'checkout_paid');
        // checkout_paid is ['icon' => 'paid'] (no 'variant') → partial override
        // Merges with _shared.checkout_paid (doesn't exist) → falls back to gray
        $this->assertEquals('gray', $result->variant());
    }

    public function test_full_definition_with_variant_is_not_partial(): void
    {
        $result = Status::for('payment', 'checkout_canceled');
        // checkout_canceled has variant, hex, icon fully defined
        $this->assertNotNull($result->variant());
        $this->assertEquals('danger', $result->variant());
    }

    public function test_string_reference_resolves_from_shared(): void
    {
        $result = Status::for('payment', 'paid');
        // 'paid' is a string reference → resolves to _shared.paid
        $this->assertEquals('success', $result->variant());
    }
}
