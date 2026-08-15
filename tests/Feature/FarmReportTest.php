<?php

namespace Tests\Feature;

use App\Models\Cattle;
use App\Models\Finances;
use App\Models\MilkProduction;
use App\Models\Poultry;
use App\Models\User;
use App\Services\FarmReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FarmReportTest extends TestCase
{
    use RefreshDatabase;

    protected function owner(): User
    {
        return User::factory()->owner()->create();
    }

    public function test_report_aggregates_real_farm_data(): void
    {
        $owner = $this->owner();
        $from = today()->startOfMonth()->toDateString();
        $to = today()->endOfMonth()->toDateString();

        Finances::create(['user_id' => $owner->id, 'type' => 'income', 'amount' => 3000, 'category' => 'sales', 'date' => today()]);
        Finances::create(['user_id' => $owner->id, 'type' => 'expense', 'amount' => 800, 'category' => 'feeds', 'date' => today()]);
        Finances::create(['user_id' => $owner->id, 'type' => 'expense', 'amount' => 200, 'category' => 'medication', 'date' => today()]);

        $cow = Cattle::query()->withoutGlobalScopes()->create([
            'user_id' => $owner->id,
            'name' => 'Bella',
            'age' => 3,
            'weight_kg' => 520,
            'breed' => 'Ayrshire',
            'gender' => 'female',
        ]);

        MilkProduction::create([
            'user_id' => $owner->id,
            'cow_id' => $cow->id,
            'morning' => 10,
            'afternoon' => 5,
            'evening' => 7,
            'date' => today(),
        ]);

        Poultry::create([
            'user_id' => $owner->id,
            'date' => today(),
            'chicken_count' => 30,
            'mortalities' => 1,
            'eggs_produced' => 20,
            'eggs_sold' => 15,
        ]);

        $report = FarmReportService::data($owner->id, $from, $to);

        $this->assertSame(3000.0, $report['income']);
        $this->assertSame(1000.0, $report['expense']);
        $this->assertSame(2000.0, $report['net']);
        $this->assertSame(22.0, $report['milkYield']);
        $this->assertSame(20, $report['eggs']);
        $this->assertSame(1, $report['counts']['cattle']);
        $this->assertSame(1, $report['counts']['milk_records']);
        $this->assertSame(1, $report['counts']['poultry_records']);
        $this->assertSame(3, count($report['recentTransactions']));
        $this->assertSame($owner->id, $report['farm']->id);
    }

    public function test_report_scopes_to_the_period(): void
    {
        $owner = $this->owner();

        $cow = Cattle::query()->withoutGlobalScopes()->create([
            'user_id' => $owner->id,
            'name' => 'Bella',
            'age' => 3,
            'weight_kg' => 520,
            'breed' => 'Ayrshire',
            'gender' => 'female',
        ]);

        MilkProduction::create([
            'user_id' => $owner->id,
            'cow_id' => $cow->id,
            'morning' => 5,
            'afternoon' => 0,
            'evening' => 0,
            'date' => today()->subMonths(2),
        ]);

        $report = FarmReportService::data($owner->id, today()->startOfMonth()->toDateString(), today()->endOfMonth()->toDateString());

        $this->assertSame(0.0, $report['milkYield']);
        $this->assertSame(0, $report['counts']['milk_records']);
    }

    public function test_report_pdf_download_returns_a_pdf(): void
    {
        $owner = $this->owner();

        $response = FarmReportService::download(
            $owner->id,
            today()->startOfMonth()->toDateString(),
            today()->endOfMonth()->toDateString(),
        );

        $this->assertStringContainsString('%PDF', (string) $response->getContent());
    }

    public function test_reports_page_access_by_role(): void
    {
        $owner = $this->owner();
        $editor = User::factory()->editor($owner->id)->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($owner)->get('/dashboard/reports')->assertOk();
        $this->actingAs($admin)->get('/dashboard/reports')->assertOk();
        $this->actingAs($editor)->get('/dashboard/reports')->assertForbidden();
    }

    public function test_finance_dashboard_access_by_role(): void
    {
        $owner = $this->owner();
        $editor = User::factory()->editor($owner->id)->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($owner)->get('/dashboard/finance')->assertOk();
        $this->actingAs($admin)->get('/dashboard/finance')->assertOk();
        $this->actingAs($editor)->get('/dashboard/finance')->assertForbidden();
    }

    public function test_admin_console_is_admin_only(): void
    {
        $owner = $this->owner();
        $editor = User::factory()->editor($owner->id)->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/dashboard/admin/console')->assertOk();
        $this->actingAs($owner)->get('/dashboard/admin/console')->assertForbidden();
        $this->actingAs($editor)->get('/dashboard/admin/console')->assertForbidden();
    }

    public function test_report_income_and_expense_categories_are_broken_down(): void
    {
        $owner = $this->owner();

        Finances::create(['user_id' => $owner->id, 'type' => 'income', 'amount' => 1000, 'category' => 'sales', 'date' => today()]);
        Finances::create(['user_id' => $owner->id, 'type' => 'income', 'amount' => 500, 'category' => 'dorper', 'date' => today()]);
        Finances::create(['user_id' => $owner->id, 'type' => 'expense', 'amount' => 300, 'category' => 'feeds', 'date' => today()]);

        $report = FarmReportService::data($owner->id, today()->startOfMonth()->toDateString(), today()->endOfMonth()->toDateString());

        $this->assertSame(1000.0, $report['incomeByCategory']['sales']);
        $this->assertSame(500.0, $report['incomeByCategory']['dorper']);
        $this->assertSame(300.0, $report['expenseByCategory']['feeds']);
    }
}
