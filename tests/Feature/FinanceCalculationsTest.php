<?php

namespace Tests\Feature;

use App\Models\Finances;
use App\Models\User;
use App\Services\FinanceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinanceCalculationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_summary_derives_totals_from_transactions(): void
    {
        $owner = User::factory()->owner()->create();

        Finances::create(['user_id' => $owner->id, 'type' => 'income', 'amount' => 1000, 'category' => 'sales', 'date' => today()]);
        Finances::create(['user_id' => $owner->id, 'type' => 'income', 'amount' => 500.5, 'category' => 'sales', 'date' => today()]);
        Finances::create(['user_id' => $owner->id, 'type' => 'expense', 'amount' => 300, 'category' => 'feeds', 'date' => today()]);

        $summary = FinanceService::summary($owner->id);

        $this->assertSame(1500.5, $summary['income']);
        $this->assertSame(300.0, $summary['expense']);
        $this->assertSame(1200.5, $summary['net']);
        $this->assertSame(3, $summary['count']);
    }

    public function test_summary_scopes_to_farm_and_period(): void
    {
        $ownerA = User::factory()->owner()->create();
        $ownerB = User::factory()->owner()->create();

        Finances::create(['user_id' => $ownerA->id, 'type' => 'income', 'amount' => 100, 'category' => 'sales', 'date' => today()->subMonth()]);
        Finances::create(['user_id' => $ownerA->id, 'type' => 'income', 'amount' => 50, 'category' => 'sales', 'date' => today()]);
        Finances::create(['user_id' => $ownerB->id, 'type' => 'income', 'amount' => 9999, 'category' => 'sales', 'date' => today()]);

        $summary = FinanceService::summary($ownerA->id, today()->startOfMonth(), today()->endOfMonth());

        $this->assertSame(50.0, $summary['income']);
        $this->assertSame(0.0, $summary['expense']);
    }

    public function test_totals_update_after_adding_a_transaction(): void
    {
        $owner = User::factory()->owner()->create();

        $this->assertSame(0.0, FinanceService::summary($owner->id)['income']);

        Finances::create(['user_id' => $owner->id, 'type' => 'income', 'amount' => 200, 'category' => 'sales', 'date' => today()]);

        $this->assertSame(200.0, FinanceService::summary($owner->id)['income']);
        $this->assertSame(200.0, FinanceService::summary($owner->id)['net']);
    }

    public function test_totals_update_after_editing_a_transaction(): void
    {
        $owner = User::factory()->owner()->create();
        $finance = Finances::create(['user_id' => $owner->id, 'type' => 'income', 'amount' => 100, 'category' => 'sales', 'date' => today()]);

        $finance->update(['amount' => 250, 'type' => 'expense', 'category' => 'medication']);

        $summary = FinanceService::summary($owner->id);

        $this->assertSame(0.0, $summary['income']);
        $this->assertSame(250.0, $summary['expense']);
        $this->assertSame(-250.0, $summary['net']);
    }

    public function test_totals_update_after_deleting_a_transaction(): void
    {
        $owner = User::factory()->owner()->create();
        $income = Finances::create(['user_id' => $owner->id, 'type' => 'income', 'amount' => 1000, 'category' => 'sales', 'date' => today()]);
        $expense = Finances::create(['user_id' => $owner->id, 'type' => 'expense', 'amount' => 400, 'category' => 'feeds', 'date' => today()]);

        $expense->delete();

        $summary = FinanceService::summary($owner->id);

        $this->assertSame(1000.0, $summary['income']);
        $this->assertSame(0.0, $summary['expense']);
        $this->assertSame(1, $summary['count']);
        $this->assertNull($expense->fresh());
    }

    public function test_summary_respects_admin_view_as_scoping(): void
    {
        $admin = User::factory()->admin()->create();
        $owner = User::factory()->owner()->create();

        Finances::create(['user_id' => $owner->id, 'type' => 'income', 'amount' => 500, 'category' => 'sales', 'date' => today()]);

        $this->actingAs($admin)->withSession(['farm_owner_id' => $owner->id]);

        $summary = FinanceService::summary();

        $this->assertSame(500.0, $summary['income']);
    }

    public function test_monthly_trend_returns_labels_and_totals(): void
    {
        $owner = User::factory()->owner()->create();
        Finances::create(['user_id' => $owner->id, 'type' => 'income', 'amount' => 100, 'category' => 'sales', 'date' => today()]);

        $trend = FinanceService::monthlyTrend($owner->id, today()->startOfMonth(), today()->endOfMonth());

        $this->assertContains(today()->format('M y'), $trend['labels']);
        $this->assertSame(100.0, $trend['income'][array_search(today()->format('M y'), $trend['labels'])]);
        $this->assertSame(0.0, $trend['expense'][array_search(today()->format('M y'), $trend['labels'])]);
    }
}
