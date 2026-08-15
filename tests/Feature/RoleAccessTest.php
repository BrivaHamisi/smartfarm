<?php

namespace Tests\Feature;

use App\Console\Commands\SendFarmingReminders;
use App\Filament\Resources\UserResource;
use App\Models\Cattle;
use App\Models\Checkup;
use App\Models\DorperBreedingRecord;
use App\Models\Finances;
use App\Models\Insemination;
use App\Models\User;
use App\Notifications\CheckupReminderNotification;
use App\Notifications\InseminationReminderNotification;
use App\Notifications\LambingReminderNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function owner(): User
    {
        return User::factory()->owner()->create();
    }

    protected function editorFor(User $owner): User
    {
        return User::factory()->editor($owner->id)->create();
    }

    protected function admin(): User
    {
        return User::factory()->admin()->create();
    }

    protected function createCowFor(User $owner, string $tag = 'QW-01'): Cattle
    {
        return Cattle::query()->withoutGlobalScopes()->create([
            'user_id' => $owner->id,
            'name' => $tag,
            'age' => 3,
            'weight_kg' => 520,
            'breed' => 'Ayrshire',
            'gender' => 'female',
        ]);
    }

    public function test_editor_cannot_access_finances_workers_or_users(): void
    {
        $editor = $this->editorFor($this->owner());

        $this->actingAs($editor)->get('/dashboard/finances')->assertForbidden();
        $this->actingAs($editor)->get('/dashboard/workers')->assertForbidden();
        $this->actingAs($editor)->get('/dashboard/users')->assertForbidden();
    }

    public function test_owner_can_access_all_farm_resources(): void
    {
        $owner = $this->owner();

        $this->actingAs($owner)->get('/dashboard/finances')->assertOk();
        $this->actingAs($owner)->get('/dashboard/workers')->assertOk();
        $this->actingAs($owner)->get('/dashboard/users')->assertOk();
        $this->actingAs($owner)->get('/dashboard/cattle')->assertOk();
    }

    public function test_editor_can_access_farm_operations(): void
    {
        $editor = $this->editorFor($this->owner());

        $this->actingAs($editor)->get('/dashboard/cattle')->assertOk();
        $this->actingAs($editor)->get('/dashboard/checkups')->assertOk();
        $this->actingAs($editor)->get('/dashboard')->assertOk();
    }

    public function test_admin_can_access_everything(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/dashboard/finances')->assertOk();
        $this->actingAs($admin)->get('/dashboard/users')->assertOk();
        $this->actingAs($admin)->get('/dashboard/cattle')->assertOk();
    }

    public function test_editor_created_records_are_attributed_to_the_farm_owner(): void
    {
        $owner = $this->owner();
        $editor = $this->editorFor($owner);

        $this->actingAs($editor);

        $cow = Cattle::create([
            'name' => 'Bella',
            'age' => 3,
            'weight_kg' => 520,
            'breed' => 'Ayrshire',
            'gender' => 'female',
        ]);

        $this->assertSame($owner->id, $cow->fresh()->user_id);
    }

    public function test_editor_only_sees_records_of_their_own_farm(): void
    {
        $ownerA = $this->owner();
        $ownerB = $this->owner();
        $this->createCowFor($ownerA, 'A-1');
        $this->createCowFor($ownerA, 'A-2');
        $this->createCowFor($ownerB, 'B-1');

        $this->actingAs($this->editorFor($ownerA));

        $this->assertSame(2, Cattle::query()->count());
        $this->assertSame(1, Cattle::query()->where('name', 'A-1')->count());
        $this->assertSame(0, Cattle::query()->where('name', 'B-1')->count());
    }

    public function test_owner_cannot_view_another_farms_record(): void
    {
        $ownerA = $this->owner();
        $ownerB = $this->owner();
        $cowB = $this->createCowFor($ownerB, 'B-1');

        $this->actingAs($ownerA)->get("/dashboard/cattle/{$cowB->id}/edit")->assertNotFound();

        $this->assertTrue($ownerB->can('view', $cowB));
        $this->assertFalse($ownerA->can('view', $cowB));
        $this->assertFalse($ownerA->can('update', $cowB));
        $this->assertFalse($ownerA->can('delete', $cowB));
    }

    public function test_editor_cannot_view_another_farms_record(): void
    {
        $ownerA = $this->owner();
        $ownerB = $this->owner();
        $cowB = $this->createCowFor($ownerB, 'B-1');

        $this->actingAs($this->editorFor($ownerA))->get("/dashboard/cattle/{$cowB->id}/edit")->assertNotFound();
    }

    public function test_editor_is_denied_finance_authorization(): void
    {
        $owner = $this->owner();
        $editor = $this->editorFor($owner);

        $this->actingAs($owner);

        $finance = Finances::create([
            'type' => 'expense',
            'amount' => 100,
            'category' => 'feeds',
            'date' => today(),
        ]);

        $this->assertFalse($editor->can('viewAny', Finances::class));
        $this->assertFalse($editor->can('view', $finance));
        $this->assertTrue($owner->can('view', $finance));
        $this->assertTrue($owner->can('create', Finances::class));
    }

    public function test_owner_can_manage_only_their_own_editors(): void
    {
        $ownerA = $this->owner();
        $ownerB = $this->owner();
        $editorA = $this->editorFor($ownerA);
        $editorB = $this->editorFor($ownerB);

        $this->actingAs($ownerA);

        $visible = UserResource::getEloquentQuery()->pluck('id');

        $this->assertTrue($visible->contains($editorA->id));
        $this->assertFalse($visible->contains($editorB->id));
        $this->assertFalse($visible->contains($ownerA->id));

        $this->assertTrue($ownerA->can('create', User::class));
        $this->assertTrue($ownerA->can('update', $editorA));
        $this->assertFalse($ownerA->can('update', $editorB));
        $this->assertFalse($ownerA->can('view', $ownerB));
        $this->assertFalse($this->editorFor($ownerA)->can('create', User::class));
    }

    public function test_owner_created_users_are_forced_to_editor_of_their_farm(): void
    {
        $owner = $this->owner();

        $this->actingAs($owner);

        $data = UserResource::normalizeManagedData([
            'name' => 'Forced Editor',
            'email' => 'forced.editor@example.com',
            'password' => 'password123',
        ]);

        $this->assertSame('editor', $data['role']);
        $this->assertSame($owner->id, $data['farm_owner_id']);
    }

    public function test_admin_view_as_farm_scopes_records_to_that_farm(): void
    {
        $ownerA = $this->owner();
        $ownerB = $this->owner();
        $this->createCowFor($ownerA, 'A-1');
        $this->createCowFor($ownerB, 'B-1');
        $admin = $this->admin();

        $this->actingAs($admin)->withSession(['farm_owner_id' => $ownerB->id]);

        $this->assertSame(1, Cattle::query()->count());
        $this->assertSame(0, Cattle::query()->where('name', 'A-1')->count());
        $this->assertSame(1, Cattle::query()->where('name', 'B-1')->count());
    }

    public function test_lambing_reminders_reach_owner_editors_and_admins_only(): void
    {
        Notification::fake();

        $owner = $this->owner();
        $editor = $this->editorFor($owner);
        $admin = $this->admin();
        $otherOwner = $this->owner();

        $record = DorperBreedingRecord::query()->withoutGlobalScopes()->create([
            'user_id' => $owner->id,
            'ewe_tag' => 'EW-100',
            'ram_tag' => 'RAM-1',
            'mating_date' => today()->subDays(60),
            'expected_lambing_date' => today()->addDays(14),
            'reminder_sent' => false,
        ]);

        $this->artisan('farm:send-reminders')->assertSuccessful();

        Notification::assertSentTo($owner, LambingReminderNotification::class);
        Notification::assertSentTo($editor, LambingReminderNotification::class);
        Notification::assertSentTo($admin, LambingReminderNotification::class);
        Notification::assertNotSentTo($otherOwner, LambingReminderNotification::class);

        $this->assertTrue((bool) $record->fresh()->reminder_sent);
    }

    public function test_checkup_and_calving_reminders_reach_the_farm_team(): void
    {
        Notification::fake();

        $owner = $this->owner();
        $editor = $this->editorFor($owner);
        $otherOwner = $this->owner();
        $cow = $this->createCowFor($owner, 'A-1');

        Checkup::query()->withoutGlobalScopes()->create([
            'user_id' => $owner->id,
            'cow_id' => $cow->id,
            'date' => today()->addDays(2),
            'type' => 'deworming',
            'is_completed' => false,
            'reminder_sent' => false,
        ]);

        Insemination::query()->withoutGlobalScopes()->create([
            'user_id' => $owner->id,
            'cow_id' => $cow->id,
            'date' => today()->subDays(250),
            'bull_number' => 'B-77',
            'successful' => true,
            'expected_dob' => today()->addDays(14),
            'reminder_sent' => false,
        ]);

        $this->artisan('farm:send-reminders')->assertSuccessful();

        Notification::assertSentTo($owner, CheckupReminderNotification::class);
        Notification::assertSentTo($editor, CheckupReminderNotification::class);
        Notification::assertNotSentTo($otherOwner, CheckupReminderNotification::class);
        Notification::assertSentTo($owner, InseminationReminderNotification::class);
        Notification::assertSentTo($editor, InseminationReminderNotification::class);
        Notification::assertNotSentTo($otherOwner, InseminationReminderNotification::class);
    }
}
