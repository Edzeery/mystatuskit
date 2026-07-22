<?php

namespace Edzeery\MyStatusKit\Tests;

use Edzeery\MyStatusKit\Support\AssetsRenderer;

class AssetsRendererTest extends TestCase
{
    public function test_render_fa_returns_link_tag(): void
    {
        $html = AssetsRenderer::render(['fa']);

        $this->assertStringContainsString('<link', $html);
        $this->assertStringContainsString('font-awesome', $html);
    }

    public function test_render_bi_returns_link_tag(): void
    {
        $html = AssetsRenderer::render(['bi']);

        $this->assertStringContainsString('<link', $html);
        $this->assertStringContainsString('bootstrap-icons', $html);
    }

    public function test_render_ion_returns_script_tag(): void
    {
        $html = AssetsRenderer::render(['ion']);

        $this->assertStringContainsString('<script', $html);
        $this->assertStringContainsString('ionicons', $html);
    }

    public function test_render_multiple_sets(): void
    {
        $html = AssetsRenderer::render(['fa', 'bi', 'ion']);

        $this->assertStringContainsString('font-awesome', $html);
        $this->assertStringContainsString('bootstrap-icons', $html);
        $this->assertStringContainsString('ionicons', $html);
    }

    public function test_render_default_sets(): void
    {
        $html = AssetsRenderer::render();

        $this->assertIsString($html);
        $this->assertNotEmpty($html);
    }

    public function test_render_unknown_set_returns_empty(): void
    {
        $html = AssetsRenderer::render(['unknown']);

        $this->assertEmpty(trim($html));
    }

    public function test_render_empty_array(): void
    {
        $html = AssetsRenderer::render([]);

        $this->assertEmpty(trim($html));
    }
}
