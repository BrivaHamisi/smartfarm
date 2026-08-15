<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\Cattle;
use App\Models\ErrorLog;
use App\Models\User;
use App\Support\Activity;
use App\Support\ErrorLogRecorder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class MonitoringTest extends TestCase
{
    use RefreshDatabase;

    protected function owner(): User
    {
        return User::factory()->owner()->create();
    }

    public function test_successful_login_is_logged(): void
    {
        $owner = User::factory()->owner()->create(['password' => 'password123']);

        $this->post('/login', ['email' => $owner->email, 'password' => 'password123']);

        $this->assertDatabaseHas('activity_logs', [
            'action' => ActivityLog::ACTION_LOGIN,
            'user_id' => $owner->id,
            'farm_id' => $owner->id,
        ]);
    }

    public function test_failed_login_is_logged_without_password(): void
    {
        $this->post('/login', ['email' => 'nobody@example.com', 'password' => 'super-secret']);

        $log = ActivityLog::query()->where('action', ActivityLog::ACTION_FAILED_LOGIN)->first();

        $this->assertNotNull($log);
        $this->assertStringContainsString('nobody@example.com', (string) $log->description);
        $this->assertStringNotContainsString('super-secret', (string) $log->description);
        $this->assertNull($log->user_id);
        $this->assertNull($log->farm_id);
    }

    public function test_logout_is_logged(): void
    {
        $owner = $this->owner();

        $this->actingAs($owner)->post('/logout');

        $this->assertDatabaseHas('activity_logs', [
            'action' => ActivityLog::ACTION_LOGOUT,
            'user_id' => $owner->id,
        ]);
    }

    public function test_registration_is_logged(): void
    {
        $this->post('/register', [
            'name' => 'New Farmer',
            'email' => 'farmer@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::query()->where('email', 'farmer@example.com')->first();

        $this->assertNotNull($user);
        $this->assertDatabaseHas('activity_logs', [
            'action' => ActivityLog::ACTION_REGISTERED,
            'user_id' => $user->id,
            'farm_id' => $user->id,
        ]);
    }

    public function test_model_crud_is_audited(): void
    {
        $owner = $this->owner();
        $this->actingAs($owner);

        $cow = Cattle::query()->withoutGlobalScopes()->create([
            'user_id' => $owner->id,
            'name' => 'Bella',
            'age' => 3,
            'weight_kg' => 520,
            'breed' => 'Ayrshire',
            'gender' => 'female',
        ]);

        $cow->update(['weight_kg' => 600]);
        $cow->delete();

        $this->assertDatabaseHas('activity_logs', [
            'action' => ActivityLog::ACTION_CREATED,
            'user_id' => $owner->id,
            'farm_id' => $owner->id,
            'subject_type' => Cattle::class,
            'subject_id' => $cow->id,
        ]);
        $this->assertDatabaseHas('activity_logs', [
            'action' => ActivityLog::ACTION_UPDATED,
            'subject_id' => $cow->id,
        ]);
        $this->assertDatabaseHas('activity_logs', [
            'action' => ActivityLog::ACTION_DELETED,
            'subject_id' => $cow->id,
        ]);
    }

    public function test_audit_descriptions_never_include_model_attributes(): void
    {
        $owner = $this->owner();
        $this->actingAs($owner);

        Cattle::query()->withoutGlobalScopes()->create([
            'user_id' => $owner->id,
            'name' => 'Secret Cow',
            'age' => 2,
            'weight_kg' => 400,
            'breed' => 'Ayrshire',
            'gender' => 'female',
        ]);

        $log = ActivityLog::query()->where('action', ActivityLog::ACTION_CREATED)->first();

        $this->assertNotNull($log);
        $this->assertStringNotContainsString('Secret Cow', (string) $log->description);
        $this->assertStringNotContainsString('400', (string) $log->description);
    }

    public function test_report_generation_is_logged(): void
    {
        $owner = $this->owner();
        $this->actingAs($owner);

        Activity::record(ActivityLog::ACTION_REPORT_GENERATED, 'Generated farm report', null, $owner->id);

        $this->assertDatabaseHas('activity_logs', [
            'action' => ActivityLog::ACTION_REPORT_GENERATED,
            'user_id' => $owner->id,
            'farm_id' => $owner->id,
        ]);
    }

    public function test_errors_are_recorded_with_context(): void
    {
        $owner = $this->owner();
        $this->actingAs($owner);

        $log = ErrorLogRecorder::record(new RuntimeException('Something broke'));

        $this->assertNotNull($log);
        $this->assertSame('error', $log->level);
        $this->assertSame('RuntimeException', $log->type);
        $this->assertStringContainsString('Something broke', $log->message);
        $this->assertSame($owner->id, $log->user_id);
        $this->assertSame($owner->id, $log->farm_id);
    }

    public function test_activity_and_error_logs_are_admin_only(): void
    {
        $owner = $this->owner();
        $editor = User::factory()->editor($owner->id)->create();
        $admin = User::factory()->admin()->create();

        $log = ActivityLog::factory()->onFarm($owner)->create();
        $error = ErrorLog::factory()->onFarm($owner)->create();

        $this->assertTrue($admin->can('viewAny', ActivityLog::class));
        $this->assertFalse($owner->can('viewAny', ActivityLog::class));
        $this->assertFalse($editor->can('viewAny', ActivityLog::class));
        $this->assertTrue($admin->can('view', $log));
        $this->assertFalse($owner->can('view', $log));
        $this->assertFalse($owner->can('delete', $log));

        $this->assertTrue($admin->can('viewAny', ErrorLog::class));
        $this->assertFalse($owner->can('viewAny', ErrorLog::class));
        $this->assertFalse($owner->can('view', $error));
    }

    public function test_console_page_renders_for_admin(): void
    {
        $admin = User::factory()->admin()->create();
        $owner = $this->owner();

        ActivityLog::factory()->onFarm($owner)->forAction(ActivityLog::ACTION_LOGIN)->create();
        ErrorLog::factory()->onFarm($owner)->create();

        $this->actingAs($admin)->get('/dashboard/admin/console')->assertOk();
    }
}
