<?php

namespace Edzeery\MyStatusKit\Tests;

class HelpersTest extends TestCase
{
    public function test_status_function_returns_status_result(): void
    {
        $result = status('payment', 'paid');

        $this->assertInstanceOf(\Edzeery\MyStatusKit\DTO\StatusResult::class, $result);
    }

    public function test_status_color_returns_string(): void
    {
        $color = status_color('payment', 'paid');

        $this->assertIsString($color);
        $this->assertNotEmpty($color);
    }

    public function test_status_color_with_dark_false(): void
    {
        $withDark = status_color('payment', 'paid', true);
        $withoutDark = status_color('payment', 'paid', false);

        $this->assertStringNotContainsString('dark:', $withoutDark);
    }

    public function test_status_hex_returns_hex_value(): void
    {
        $hex = status_hex('payment', 'paid');

        $this->assertEquals('#16a34a', $hex);
    }

    public function test_status_label_returns_string(): void
    {
        $label = status_label('payment', 'paid');

        $this->assertIsString($label);
        $this->assertNotEmpty($label);
    }

    public function test_status_label_with_locale(): void
    {
        $ar = status_label('payment', 'paid', 'ar');
        $en = status_label('payment', 'paid', 'en');

        $this->assertEquals('مدفوع', $ar);
        $this->assertEquals('Paid', $en);
    }

    public function test_status_icon_returns_html(): void
    {
        $icon = status_icon('payment', 'paid', 'bi');

        $this->assertIsString($icon);
        $this->assertNotEmpty($icon);
    }

    public function test_status_badge_returns_html(): void
    {
        $badge = status_badge('payment', 'paid', 'bi');

        $this->assertStringContainsString('<span', $badge);
    }

    public function test_icon_function_returns_html(): void
    {
        $html = icon('paid', 'fa', 'text-lg');

        $this->assertStringContainsString('<i', $html);
        $this->assertStringContainsString('text-lg', $html);
    }

    public function test_svg_icon_function(): void
    {
        $svg = svg_icon('heroicons/check-circle', 'w-5 h-5');

        $this->assertNotNull($svg);
        $this->assertStringContainsString('<svg', $svg);
    }

    public function test_getIconHtml_passthrough(): void
    {
        $raw = '<i class="fas fa-custom"></i>';
        $result = getIconHtml($raw);

        $this->assertEquals($raw, $result);
    }

    public function test_getIconHtml_renders_icon(): void
    {
        $html = getIconHtml('paid', 'fa');

        $this->assertStringContainsString('<i', $html);
    }

    public function test_getIconHtml_svg_mode(): void
    {
        $result = getIconHtml('check-circle', 'svg');

        $this->assertIsString($result);
    }

    public function test_status_kit_assets_returns_string(): void
    {
        $html = status_kit_assets(['fa']);

        $this->assertIsString($html);
    }

    public function test_helpers_do_not_overwrite_existing(): void
    {
        $this->assertTrue(function_exists('status'));
        $this->assertTrue(function_exists('status_color'));
        $this->assertTrue(function_exists('status_hex'));
        $this->assertTrue(function_exists('status_label'));
        $this->assertTrue(function_exists('status_icon'));
        $this->assertTrue(function_exists('status_badge'));
        $this->assertTrue(function_exists('icon'));
        $this->assertTrue(function_exists('svg_icon'));
        $this->assertTrue(function_exists('getIconHtml'));
        $this->assertTrue(function_exists('status_kit_assets'));
    }
}
