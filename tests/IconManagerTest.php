<?php

namespace Edzeery\MyStatusKit\Tests;

use Edzeery\MyStatusKit\IconManager;

class IconManagerTest extends TestCase
{
    private IconManager $iconManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->iconManager = app(IconManager::class);
    }

    public function test_render_fa_returns_valid_html(): void
    {
        $html = $this->iconManager->render('paid', 'fa');

        $this->assertStringContainsString('<i', $html);
        $this->assertStringContainsString('fa-check-circle', $html);
    }

    public function test_render_bi_returns_valid_html(): void
    {
        $html = $this->iconManager->render('paid', 'bi');

        $this->assertStringContainsString('<i', $html);
        $this->assertStringContainsString('bi-check-circle', $html);
    }

    public function test_render_ion_returns_valid_html(): void
    {
        $html = $this->iconManager->render('paid', 'ion');

        $this->assertStringContainsString('<ion-icon', $html);
        $this->assertStringContainsString('checkmark-done-circle-outline', $html);
    }

    public function test_render_passes_through_raw_html(): void
    {
        $raw = '<i class="fas fa-custom"></i>';
        $html = $this->iconManager->render($raw, 'fa');

        $this->assertEquals($raw, $html);
    }

    public function test_render_with_classes(): void
    {
        $html = $this->iconManager->render('paid', 'fa', 'text-lg');

        $this->assertStringContainsString('text-lg', $html);
    }

    public function test_render_ion_with_classes(): void
    {
        $html = $this->iconManager->render('paid', 'ion', 'custom-class');

        $this->assertStringContainsString('class="custom-class"', $html);
    }

    public function test_render_uses_default_set_when_not_specified(): void
    {
        $html = $this->iconManager->render('paid');

        $this->assertNotEmpty($html);
        $this->assertIsString($html);
    }

    public function test_render_returns_default_for_unknown_icon(): void
    {
        $html = $this->iconManager->render('totally-unknown-icon-xyz', 'fa');

        $this->assertNotEmpty($html);
        $this->assertStringContainsString('fa-circle', $html);
    }

    public function test_svg_returns_content_for_existing_file(): void
    {
        $svg = $this->iconManager->svg('check-circle', '', 'heroicons');

        $this->assertNotNull($svg);
        $this->assertStringContainsString('<svg', $svg);
    }

    public function test_svg_returns_null_for_nonexistent_file(): void
    {
        $svg = $this->iconManager->svg('totally-nonexistent-file', '', 'heroicons');

        $this->assertNull($svg);
    }

    public function test_svg_injects_default_size_when_missing(): void
    {
        $svg = $this->iconManager->svg('check-circle', '', 'heroicons');

        $this->assertNotNull($svg);
        $this->assertStringContainsString('width="1em"', $svg);
        $this->assertStringContainsString('height="1em"', $svg);
    }

    public function test_svg_injects_classes(): void
    {
        $svg = $this->iconManager->svg('check-circle', 'my-class', 'heroicons');

        $this->assertNotNull($svg);
        $this->assertStringContainsString('class="my-class"', $svg);
    }

    public function test_heroicon_returns_svg(): void
    {
        $svg = $this->iconManager->heroicon('check-circle', 'w-5 h-5');

        $this->assertNotNull($svg);
        $this->assertStringContainsString('<svg', $svg);
        $this->assertStringContainsString('w-5 h-5', $svg);
    }

    public function test_heroicon_returns_svg_for_paid(): void
    {
        $svg = $this->iconManager->heroicon('currency-dollar');

        $this->assertNotNull($svg);
        $this->assertStringContainsString('<svg', $svg);
    }
}
