<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\Finances;
use App\Models\Invoice;
use App\Models\User;
use App\Services\InvoiceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_numbers_are_unique_and_sequential(): void
    {
        $owner = User::factory()->owner()->create();
        $year = now()->format('Y');

        $this->assertSame('INV-'.$year.'-0001', InvoiceService::generateNumber((int) $year));

        Invoice::create([
            'user_id' => $owner->id,
            'invoice_number' => 'INV-'.$year.'-0001',
            'customer_name' => 'Client A',
            'date' => today(),
            'amount' => 100,
            'status' => Invoice::STATUS_DRAFT,
        ]);

        $this->assertSame('INV-'.$year.'-0002', InvoiceService::generateNumber((int) $year));
    }

    public function test_create_from_finance_copies_values_and_logs_activity(): void
    {
        $owner = User::factory()->owner()->create();
        $this->actingAs($owner);

        $finance = Finances::create([
            'user_id' => $owner->id,
            'type' => 'income',
            'amount' => 12500,
            'category' => 'sales',
            'date' => today(),
            'description' => 'Milk sales to co-op',
            'source' => 'Co-op',
        ]);

        $invoice = InvoiceService::createFromFinance($finance, [
            'customer_name' => 'Co-op',
            'amount' => 12500,
            'date' => today()->toDateString(),
            'status' => Invoice::STATUS_SENT,
        ]);

        $this->assertSame($owner->id, $invoice->user_id);
        $this->assertSame($finance->id, $invoice->finance_id);
        $this->assertSame('INV-'.now()->format('Y').'-0001', $invoice->invoice_number);
        $this->assertSame(12500.0, (float) $invoice->amount);
        $this->assertSame(Invoice::STATUS_SENT, $invoice->status);
        $this->assertSame($owner->id, $invoice->created_by);

        $this->assertDatabaseHas('activity_logs', [
            'action' => ActivityLog::ACTION_INVOICE_GENERATED,
            'farm_id' => $owner->id,
            'subject_type' => Invoice::class,
            'subject_id' => $invoice->id,
        ]);
    }

    public function test_create_from_finance_sequences_after_existing_invoices(): void
    {
        $owner = User::factory()->owner()->create();
        $this->actingAs($owner);

        $finance = Finances::create(['user_id' => $owner->id, 'type' => 'income', 'amount' => 500, 'category' => 'sales', 'date' => today()]);

        Invoice::create([
            'user_id' => $owner->id,
            'invoice_number' => 'INV-'.now()->format('Y').'-0001',
            'customer_name' => 'Existing',
            'date' => today(),
            'amount' => 100,
        ]);

        $invoice = InvoiceService::createFromFinance($finance, ['customer_name' => 'Co-op']);

        $this->assertSame('INV-'.now()->format('Y').'-0002', $invoice->invoice_number);
    }

    public function test_only_finance_managers_can_view_invoices(): void
    {
        $owner = User::factory()->owner()->create();
        $editor = User::factory()->editor($owner->id)->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($owner)->get('/dashboard/invoices')->assertOk();
        $this->actingAs($admin)->get('/dashboard/invoices')->assertOk();
        $this->actingAs($editor)->get('/dashboard/invoices')->assertForbidden();
    }

    public function test_owner_cannot_see_or_manage_another_farms_invoice(): void
    {
        $ownerA = User::factory()->owner()->create();
        $ownerB = User::factory()->owner()->create();

        $invoiceB = Invoice::factory()->forOwner($ownerB)->create();

        $this->actingAs($ownerA);

        $this->assertFalse($ownerA->can('view', $invoiceB));
        $this->assertFalse($ownerA->can('update', $invoiceB));
        $this->assertFalse($ownerA->can('delete', $invoiceB));
        $this->assertTrue($ownerB->can('view', $invoiceB));
    }

    public function test_admin_can_view_any_invoice(): void
    {
        $owner = User::factory()->owner()->create();
        $invoice = Invoice::factory()->forOwner($owner)->create();

        $admin = User::factory()->admin()->create();

        $this->assertTrue($admin->can('view', $invoice));
        $this->assertTrue($admin->can('viewAny', Invoice::class));
    }

    public function test_invoice_can_be_marked_paid(): void
    {
        $owner = User::factory()->owner()->create();
        $invoice = Invoice::factory()->forOwner($owner)->create(['status' => Invoice::STATUS_DRAFT]);

        $this->assertFalse($invoice->isPaid());

        $invoice->update(['status' => Invoice::STATUS_PAID]);

        $this->assertTrue($invoice->fresh()->isPaid());
    }

    public function test_invoice_pdf_download_returns_a_pdf(): void
    {
        $owner = User::factory()->owner()->create();
        $invoice = Invoice::factory()->forOwner($owner)->create();

        $response = $this->actingAs($owner)->get('/dashboard/invoices');

        $this->assertSame('INV-'.now()->format('Y').'-0001', $invoice->invoice_number);
        $this->assertStringContainsString('%PDF', (string) InvoiceService::download($invoice)->getContent());
    }
}
