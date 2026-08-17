<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\FarmReportService;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PdfController extends Controller
{
    public function invoice(Invoice $invoice)
    {
        $invoice->loadMissing(['user', 'finance', 'creator']);

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', ['invoice' => $invoice])
            ->download($invoice->invoice_number.'.pdf');
    }

    public function farmReport(Request $request)
    {
        $user = auth()->user();
        $farmId = $user?->isAdmin()
            ? (int) ($request->input('farm_id', 0))
            : (int) ($user?->farmId() ?? 0);

        if (! $farmId) {
            abort(400, 'No farm selected.');
        }

        $from = $request->input('from', Carbon::now()->startOfMonth()->toDateString());
        $until = $request->input('until', Carbon::now()->endOfMonth()->toDateString());

        $report = FarmReportService::data($farmId, $from, $until);

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.farm-report', ['report' => $report])
            ->setPaper('a4')
            ->download('farm-report-'.$farmId.'-'.Carbon::parse($from)->format('Y-m-d').'.pdf');
    }
}
