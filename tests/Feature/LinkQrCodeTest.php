<?php

namespace Tests\Feature;

use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LinkQrCodeTest extends TestCase
{
    use RefreshDatabase;

    private function makeLink(string $short, string $creator): Link
    {
        $link = new Link();
        $link->short = $short;
        $link->url = 'https://example.com';
        $link->on_frontpage = false;
        $link->creator = $creator;
        $link->save();

        return $link;
    }

    #[Test]
    public function teacher_can_view_the_qr_code_for_a_link(): void
    {
        $teacher = $this->getTestTeacher();
        $link = $this->makeLink('ABC', $teacher->id);

        $response = $this->actingAs($teacher)->get(route('links.qr', $link->short));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/svg+xml');
    }

    #[Test]
    public function qr_code_can_be_downloaded_as_an_attachment(): void
    {
        $teacher = $this->getTestTeacher();
        $link = $this->makeLink('ABC', $teacher->id);

        $response = $this->actingAs($teacher)->get(route('links.qr', ['link' => $link->short, 'download' => 1]));

        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition', 'attachment; filename="ABC-qr.svg"');
    }

    #[Test]
    public function guest_cannot_view_the_qr_code(): void
    {
        $teacher = $this->getTestTeacher();
        $link = $this->makeLink('ABC', $teacher->id);

        $response = $this->get(route('links.qr', $link->short));

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function auto_generated_short_codes_are_qr_alphanumeric_safe(): void
    {
        $teacher = $this->getTestTeacher();

        $this->actingAs($teacher)->post('/links', [
            'url' => 'https://example.com',
        ]);

        $link = Link::first();

        $this->assertNotNull($link);
        $this->assertMatchesRegularExpression('/^[0-9A-Z]+$/', $link->short);
    }

    #[Test]
    public function custom_short_codes_are_stored_uppercase(): void
    {
        $teacher = $this->getTestTeacher();

        $this->actingAs($teacher)->post('/links', [
            'short' => 'teacher-code',
            'url' => 'https://example.com',
        ]);

        $link = Link::first();

        $this->assertNotNull($link);
        $this->assertSame('TEACHER-CODE', $link->short);
    }

    #[Test]
    public function custom_short_codes_reject_underscores(): void
    {
        $teacher = $this->getTestTeacher();

        $response = $this->actingAs($teacher)->post('/links', [
            'short' => 'not_allowed',
            'url' => 'https://example.com',
        ]);

        $response->assertSessionHasErrors('short');
        $this->assertNull(Link::first());
    }
}
