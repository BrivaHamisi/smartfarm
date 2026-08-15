<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Finances;
use App\Models\Invoice;
use App\Support\Activity;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class InvoiceService
{
    public static function generateNumber(int $year): string
    {
        $prefix = 'INV-'.$year.'-';

        $last = Invoice::query()
            ->where('invoice_number', 'like', $prefix.'%')
            ->orderByRaw('LENGTH(invoice_number) DESC, invoice_number DESC')
            ->value('invoice_number');

        $sequence = $last ? ((int) substr($last, strlen($prefix))) + 1 : 1;

        return $prefix.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }

    public static function createFromFinance(Finances $finance, array $data): Invoice
    {
        return DB::transaction(function () use ($finance, $data) {
            $attempts = 0;

            while (true) {
                try {
                    $invoice = Invoice::query()->create([
                        'user_id' => $finance->user_id,
                        'invoice_number' => static::generateNumber(Carbon::parse($data['date'] ?? today())->year),
                        'finance_id' => $finance->id,
                        'customer_name' => $data['customer_name'] ?? null,
                        'date' => $data['date'] ?? today(),
                        'due_date' => $data['due_date'] ?? null,
                        'amount' => $data['amount'] ?? $finance->amount,
                        'status' => $data['status'] ?? Invoice::STATUS_DRAFT,
                        'notes' => $data['notes'] ?? null,
                        'created_by' => auth()->id(),
                    ]);
                    break;
                } catch (Throwable $e) {
                    if (++$attempts >= 5) {
                        throw $e;
                    }
                }
            }

            Activity::record(
                ActivityLog::ACTION_INVOICE_GENERATED,
                'Generated '.$invoice->invoice_number,
                null,
                $invoice->user_id,
                Invoice::class,
                $invoice->id,
            );

            return $invoice;
        });
    }

    public static function download(Invoice $invoice): mixed
    {
        $invoice->loadMissing(['user', 'finance', 'creator']);

        return Pdf::loadView('pdf.invoice', ['invoice' => $invoice])
            ->stream($invoice->invoice_number.'.pdf');
    }
}
