@php
    $farm = $invoice->user;
    $statusColor = match ($invoice->status) {
        'paid' => '#16a34a',
        'sent' => '#d97706',
        default => '#5b6472',
    };
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1f2937;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 32px;
        }
        .brand { display: flex; align-items: center; gap: 8px; }
        .brand-mark {
            width: 34px; height: 34px; border-radius: 8px;
            background: #0d8a4e; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 16px;
        }
        .brand-name { font-size: 17px; font-weight: 700; letter-spacing: -0.02em; }
        .head { display: flex; justify-content: space-between; align-items: flex-start; }
        .invoice-title { font-size: 26px; font-weight: 700; color: #0d8a4e; margin: 24px 0 4px; }
        .meta { color: #6b7280; }
        .rule { height: 2px; background: #0d8a4e; margin: 20px 0; border-radius: 2px; }
        .columns { width: 100%; }
        .columns td { vertical-align: top; padding-bottom: 16px; }
        .label { font-size: 9px; text-transform: uppercase; letter-spacing: 0.08em; color: #9ca3af; margin-bottom: 3px; }
        .value { font-size: 12px; font-weight: 600; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 8px; }
        table.items th {
            text-align: left; font-size: 9px; text-transform: uppercase; letter-spacing: 0.08em;
            color: #6b7280; padding: 8px; border-bottom: 2px solid #e5e7eb;
        }
        table.items td { padding: 10px 8px; border-bottom: 1px solid #f3f4f6; }
        .totals { width: 280px; margin-left: auto; margin-top: 16px; border-collapse: collapse; }
        .totals td { padding: 5px 0; }
        .totals .grand { font-size: 15px; font-weight: 700; color: #0d8a4e; }
        .status {
            display: inline-block; padding: 4px 12px; border-radius: 999px;
            color: #fff; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;
            background: {{ $statusColor }};
        }
        .foot { margin-top: 28px; padding-top: 14px; border-top: 1px solid #e5e7eb; color: #9ca3af; font-size: 9px; text-align: center; }
        .bank td { padding: 3px 0; }
    </style>
</head>
<body>
    <div class="head">
        <div class="brand">
            <div class="brand-mark">SF</div>
            <div>
                <div class="brand-name">SmartFarm</div>
                <div class="meta">Smart agriculture management</div>
            </div>
        </div>
        <div class="status">{{ strtoupper($invoice->status) }}</div>
    </div>

    <div class="invoice-title">INVOICE</div>
    <div class="meta">{{ $invoice->invoice_number }}</div>

    <div class="rule"></div>

    <table class="columns">
        <tr>
            <td style="width:50%">
                <div class="label">Billed from</div>
                <div class="value">{{ $farm?->name ?? 'SmartFarm' }}</div>
                <div class="meta">{{ $farm?->email ?? '' }}</div>
            </td>
            <td style="width:50%">
                <table style="width:100%">
                    <tr>
                        <td>
                            <div class="label">Invoice date</div>
                            <div class="value">{{ $invoice->date->format('d M Y') }}</div>
                        </td>
                        <td>
                            <div class="label">Due date</div>
                            <div class="value">{{ $invoice->due_date?->format('d M Y') ?? '—' }}</div>
                        </td>
                    </tr>
                    @if ($invoice->customer_name)
                        <tr>
                            <td colspan="2" style="padding-top:10px">
                                <div class="label">Bill to</div>
                                <div class="value">{{ $invoice->customer_name }}</div>
                            </td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th style="width:12%">#</th>
                <th>Description</th>
                <th style="text-align:right; width:15%">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>
                    <div style="font-weight:600">
                        {{ $invoice->notes ?: ($invoice->finance?->description ?: $invoice->finance?->source ?: 'Invoice line item') }}
                    </div>
                    @if ($invoice->finance_id)
                        <div class="meta">Source transaction #{{ $invoice->finance_id }}</div>
                    @endif
                </td>
                <td style="text-align:right; font-weight:600">KSh {{ number_format((float) $invoice->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td style="color:#6b7280">Subtotal</td>
            <td style="text-align:right">KSh {{ number_format((float) $invoice->amount, 2) }}</td>
        </tr>
        <tr>
            <td class="grand" style="padding-top:10px">Total due</td>
            <td class="grand" style="text-align:right; padding-top:10px">KSh {{ number_format((float) $invoice->amount, 2) }}</td>
        </tr>
    </table>

    <div class="foot">
        Generated with SmartFarm · {{ $invoice->invoice_number }} · {{ now()->format('d M Y H:i') }}
    </div>
</body>
</html>
