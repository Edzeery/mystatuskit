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

    // --- Edge cases ---

    public function test_for_unknown_domain_returns_gray_fallback(): void
    {
        $result = Status::for('totally_fake', 'something');
        $this->assertEquals('gray', $result->variant());
        $this->assertEquals('#9ca3af', $result->hex());
    }

    public function test_for_unknown_status_in_valid_domain_returns_gray_fallback(): void
    {
        $result = Status::for('payment', 'definitely_not_real');
        $this->assertEquals('gray', $result->variant());
    }

    public function test_domain_returns_empty_for_nonexistent(): void
    {
        $results = Status::domain('nonexistent_domain_xyz');
        $this->assertIsArray($results);
        $this->assertEmpty($results);
    }

    public function test_label_falls_back_to_headline_for_unknown(): void
    {
        $result = Status::for('payment', 'some_unknown_status');
        $label = $result->label();
        // Str::headline('some_unknown_status') → 'Some Unknown Status'
        $this->assertEquals('Some Unknown Status', $label);
    }

    public function test_label_with_specific_locale(): void
    {
        $result = Status::for('payment', 'paid');
        $labelEn = $result->label('en');
        $labelFr = $result->label('fr');
        $labelAr = $result->label('ar');
        $this->assertEquals('Paid', $labelEn);
        $this->assertEquals('Payé', $labelFr);
        $this->assertEquals('مدفوع', $labelAr);
    }

    public function test_color_returns_bootstrap_class_by_default(): void
    {
        $result = Status::for('payment', 'paid');
        $color = $result->color();
        $this->assertStringContainsString('text-bg-success', $color);
    }

    public function test_color_tailwind_returns_classes(): void
    {
        $result = Status::for('payment', 'paid');
        $color = $result->color(framework: 'tailwind');
        $this->assertStringContainsString('text-green', $color);
        $this->assertStringContainsString('bg-green', $color);
    }

    public function test_color_tailwind_dark_mode(): void
    {
        $result = Status::for('payment', 'paid');
        $colorWithDark = $result->color(true, 'tailwind');
        $colorWithoutDark = $result->color(false, 'tailwind');
        $this->assertStringContainsString('dark:', $colorWithDark);
        $this->assertStringNotContainsString('dark:', $colorWithoutDark);
    }

    public function test_badge_classes_contains_framework_base(): void
    {
        $result = Status::for('payment', 'paid');
        $classes = $result->badgeClasses();
        $this->assertStringContainsString('badge', $classes);
        $this->assertStringContainsString('d-inline-flex', $classes);
    }

    public function test_badge_without_icon_does_not_contain_icon_tag(): void
    {
        $result = Status::for('payment', 'paid');
        $html = $result->badgeWithoutIcon();
        $this->assertStringNotContainsString('<i ', $html);
        $this->assertStringNotContainsString('<ion-icon', $html);
        $this->assertStringContainsString('<span', $html);
    }

    public function test_icon_only_returns_html_tag(): void
    {
        $result = Status::for('payment', 'paid');
        $html = $result->iconOnly('bi');
        $this->assertStringContainsString('<i', $html);
    }

    public function test_light_class_returns_value(): void
    {
        $result = Status::for('payment', 'paid');
        $light = $result->lightClass();
        $this->assertNotEmpty($light);
        $this->assertStringContainsString('green', $light);
    }

    public function test_dark_class_returns_value(): void
    {
        $result = Status::for('payment', 'paid');
        $dark = $result->darkClass();
        $this->assertNotEmpty($dark);
        $this->assertStringContainsString('dark:', $dark);
    }

    public function test_hex_returns_valid_hex(): void
    {
        $result = Status::for('payment', 'paid');
        $hex = $result->hex();
        $this->assertMatchesRegularExpression('/^#[0-9a-fA-F]{6}$/', $hex);
    }

    public function test_variant_returns_valid_variant(): void
    {
        $result = Status::for('payment', 'paid');
        $variant = $result->variant();
        $this->assertContains($variant, ['success', 'warning', 'danger', 'info', 'gray']);
    }

    public function test_to_array_contains_all_keys(): void
    {
        $result = Status::for('payment', 'paid');
        $array = $result->toArray();
        $this->assertArrayHasKey('domain', $array);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('variant', $array);
        $this->assertArrayHasKey('color', $array);
        $this->assertArrayHasKey('hex', $array);
        $this->assertArrayHasKey('label', $array);
        $this->assertArrayHasKey('icon', $array);
    }

    // --- SVG Sanitization ---

    public function test_sanitize_svg_removes_script_tags(): void
    {
        $svg = '<svg><script>alert("xss")</script><circle r="10"/></svg>';
        $manager = new \Edzeery\MyStatusKit\IconManager();
        $reflection = new \ReflectionClass($manager);
        $method = $reflection->getMethod('sanitizeSvg');
        $method->setAccessible(true);

        $clean = $method->invoke($manager, $svg);
        $this->assertStringNotContainsString('<script', $clean);
        $this->assertStringContainsString('<circle', $clean);
    }

    public function test_sanitize_svg_removes_event_handlers(): void
    {
        $svg = '<svg onload="alert(1)" onclick="steal()"><circle r="10"/></svg>';
        $manager = new \Edzeery\MyStatusKit\IconManager();
        $reflection = new \ReflectionClass($manager);
        $method = $reflection->getMethod('sanitizeSvg');
        $method->setAccessible(true);

        $clean = $method->invoke($manager, $svg);
        $this->assertStringNotContainsString('onload', $clean);
        $this->assertStringNotContainsString('onclick', $clean);
    }

    public function test_sanitize_svg_removes_foreign_object(): void
    {
        $svg = '<svg><foreignObject><div>evil</div></foreignObject><circle r="10"/></svg>';
        $manager = new \Edzeery\MyStatusKit\IconManager();
        $reflection = new \ReflectionClass($manager);
        $method = $reflection->getMethod('sanitizeSvg');
        $method->setAccessible(true);

        $clean = $method->invoke($manager, $svg);
        $this->assertStringNotContainsString('foreignObject', $clean);
        $this->assertStringContainsString('<circle', $clean);
    }

    public function test_sanitize_svg_removes_use_tags(): void
    {
        $svg = '<svg><use href="external.svg"/><circle r="10"/></svg>';
        $manager = new \Edzeery\MyStatusKit\IconManager();
        $reflection = new \ReflectionClass($manager);
        $method = $reflection->getMethod('sanitizeSvg');
        $method->setAccessible(true);

        $clean = $method->invoke($manager, $svg);
        $this->assertStringNotContainsString('<use', $clean);
    }

    public function test_sanitize_svg_removes_data_uris(): void
    {
        $svg = '<svg><a href="data:text/html,<script>alert(1)</script>"><circle r="10"/></a></svg>';
        $manager = new \Edzeery\MyStatusKit\IconManager();
        $reflection = new \ReflectionClass($manager);
        $method = $reflection->getMethod('sanitizeSvg');
        $method->setAccessible(true);

        $clean = $method->invoke($manager, $svg);
        $this->assertStringNotContainsString('data:', $clean);
    }

    // --- Hex Validation ---

    public function test_hex_returns_valid_hex_for_valid_config(): void
    {
        $result = Status::for('payment', 'paid');
        $hex = $result->hex();
        $this->assertMatchesRegularExpression('/^#[0-9a-fA-F]{6}$/', $hex);
    }

    public function test_hex_returns_fallback_for_invalid_hex(): void
    {
        config()->set('status-kit-statuses.payment.test_bad_hex', [
            'variant' => 'info',
            'hex' => 'not-a-hex-color',
            'icon' => 'default',
        ]);
        config()->set('status-kit-statuses.payment.test_bad_hex.light', 'text-blue');
        config()->set('status-kit-statuses.payment.test_bad_hex.dark', 'dark:text-blue');

        $result = Status::for('payment', 'test_bad_hex');
        $this->assertEquals('#9ca3af', $result->hex());
    }

    // --- SRI Attributes ---

    public function test_assets_renderer_includes_sri_integrity(): void
    {
        $html = \Edzeery\MyStatusKit\Support\AssetsRenderer::render(['fa']);
        $this->assertStringContainsString('integrity="', $html);
        $this->assertStringContainsString('crossorigin="anonymous"', $html);
    }
}
