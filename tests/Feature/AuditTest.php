<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use OwenIt\Auditing\Models\Audit;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Auditing is suppressed when runningInConsole() (which PHPUnit triggers).
        // Enable it so factory-created models produce real Audit records.
        config(['audit.console' => true]);
    }

    // -------------------------------------------------------------------------
    // Admin access
    // -------------------------------------------------------------------------

    #[Test]
    public function admin_can_access_audit_index(): void
    {
        $admin = $this->getTestAdmin();

        $this->actingAs($admin)
            ->get(route('audits.index'))
            ->assertStatus(200);
    }

    #[Test]
    public function admin_can_access_audit_show(): void
    {
        $admin = $this->getTestAdmin();
        $audit = $this->latestAudit();

        $this->actingAs($admin)
            ->get(route('audits.show', $audit->id))
            ->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // Teacher access
    // -------------------------------------------------------------------------

    #[Test]
    public function teacher_cannot_access_audit_index(): void
    {
        $teacher = $this->getTestTeacher();

        $this->actingAs($teacher)
            ->get(route('audits.index'))
            ->assertStatus(403);
    }

    #[Test]
    public function teacher_cannot_access_audit_show(): void
    {
        $this->getTestStudent();
        $audit = $this->latestAudit();

        $teacher = $this->getTestTeacher();

        $this->actingAs($teacher)
            ->get(route('audits.show', $audit->id))
            ->assertStatus(403);
    }

    // -------------------------------------------------------------------------
    // Student access
    // -------------------------------------------------------------------------

    #[Test]
    public function student_cannot_access_audit_index(): void
    {
        $student = $this->getTestStudent();

        $this->actingAs($student)
            ->get(route('audits.index'))
            ->assertStatus(403);
    }

    #[Test]
    public function student_cannot_access_audit_show(): void
    {
        $this->getTestStudent('000001');
        $audit = $this->latestAudit();

        $student = $this->getTestStudent('000002');

        $this->actingAs($student)
            ->get(route('audits.show', $audit->id))
            ->assertStatus(403);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function latestAudit(): Audit
    {
        return Audit::latest()->firstOrFail();
    }
}
