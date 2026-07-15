<?php

namespace Edzeery\MyStatusKit\Tests;

use Edzeery\MyStatusKit\DTO\StatusResult;

class StatusResultTest extends TestCase
{
    private StatusResult $paidResult;
    private StatusResult $pendingResult;
    private StatusResult $grayResult;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paidResult = \Edzeery\MyStatusKit\Facades\Status::for('payment', 'paid');
        $this->pendingResult = \Edzeery\MyStatusKit\Facades\Status::for('payment', 'pending');
        $this->grayResult = \Edzeery\MyStatusKit\Facades\Status::for('payment', 'nonexistent');
    }

    public function test_variant_returns_correct_value(): void
    {
        $this->assertEquals('success', $this->paidResult->variant());
        $this->assertEquals('warning', $this->pendingResult->variant());
        $this->assertEquals('gray', $this->grayResult->variant());
    }

    public function test_hex_returns_correct_value(): void
    {
        $this->assertEquals('#16a34a', $this->paidResult->hex());
        $this->assertEquals('#facc15', $this->pendingResult->hex());
        $this->assertEquals('#9ca3af', $this->grayResult->hex());
    }

    public function test_color_bootstrap_returns_correct_class(): void
    {
        $color = $this->paidResult->color(framework: 'bootstrap');

        $this->assertEquals('text-bg-success', $color);
    }

    public function test_color_tailwind_returns_correct_classes(): void
    {
        $color = $this->paidResult->color(framework: 'tailwind');

        $this->assertStringContainsString('text-green-700', $color);
        $this->assertStringContainsString('bg-green-100', $color);
    }

    public function test_color_tailwind_dark_mode(): void
    {
        $withDark = $this->paidResult->color(withDark: true, framework: 'tailwind');
        $withoutDark = $this->paidResult->color(withDark: false, framework: 'tailwind');

        $this->assertStringContainsString('dark:', $withDark);
        $this->assertStringNotContainsString('dark:', $withoutDark);
    }

    public function test_label_returns_translated_string(): void
    {
        $label = $this->paidResult->label();

        $this->assertIsString($label);
        $this->assertNotEmpty($label);
    }

    public function test_label_with_specific_locale(): void
    {
        $arLabel = $this->paidResult->label('ar');
        $enLabel = $this->paidResult->label('en');
        $frLabel = $this->paidResult->label('fr');

        $this->assertEquals('مدفوع', $arLabel);
        $this->assertEquals('Paid', $enLabel);
        $this->assertEquals('Payé', $frLabel);
    }

    public function test_label_falls_back_to_headline_for_unknown_status(): void
    {
        $label = $this->grayResult->label('en');

        $this->assertIsString($label);
        $this->assertNotEmpty($label);
    }

    public function test_icon_returns_html(): void
    {
        $icon = $this->paidResult->icon('bi');

        $this->assertIsString($icon);
        $this->assertNotEmpty($icon);
    }

    public function test_icon_returns_empty_for_unknown_icon(): void
    {
        $result = \Edzeery\MyStatusKit\Facades\Status::for('payment', 'nonexistent');
        $icon = $result->icon('bi');

        $this->assertIsString($icon);
    }

    public function test_badge_returns_complete_html(): void
    {
        $badge = $this->paidResult->badge('bi');

        $this->assertStringContainsString('<span', $badge);
        $this->assertStringContainsString('</span>', $badge);
    }

    public function test_badge_classes_bootstrap(): void
    {
        $classes = $this->paidResult->badgeClasses(framework: 'bootstrap');

        $this->assertStringContainsString('badge', $classes);
        $this->assertStringContainsString('text-bg-success', $classes);
    }

    public function test_badge_classes_tailwind(): void
    {
        $classes = $this->paidResult->badgeClasses(framework: 'tailwind');

        $this->assertStringContainsString('inline-flex', $classes);
        $this->assertStringContainsString('text-green-700', $classes);
    }

    public function test_to_array_returns_all_fields(): void
    {
        $array = $this->paidResult->toArray();

        $this->assertArrayHasKey('domain', $array);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('variant', $array);
        $this->assertArrayHasKey('color', $array);
        $this->assertArrayHasKey('hex', $array);
        $this->assertArrayHasKey('label', $array);
        $this->assertArrayHasKey('icon', $array);

        $this->assertEquals('payment', $array['domain']);
        $this->assertEquals('paid', $array['status']);
    }

    public function test_light_class_returns_value(): void
    {
        $light = $this->paidResult->lightClass();

        $this->assertStringContainsString('text-green-700', $light);
    }

    public function test_dark_class_returns_value(): void
    {
        $dark = $this->paidResult->darkClass();

        $this->assertStringContainsString('dark:', $dark);
    }
}
