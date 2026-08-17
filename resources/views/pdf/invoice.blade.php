@php
    $farm = $invoice->user;
    $statusColor = match ($invoice->status) {
        'paid' => '#16a34a',
        'sent' => '#d97706',
        default => '#5b6472',
    };
    $statusBg = match ($invoice->status) {
        'paid' => '#f0fdf4',
        'sent' => '#fffbeb',
        default => '#f8fafc',
    };
    $statusBorder = match ($invoice->status) {
        'paid' => '#bbf7d0',
        'sent' => '#fde68a',
        default => '#e2e8f0',
    };
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1e293b;
            font-size: 10.5px;
            line-height: 1.55;
            background: #fff;
        }

        .page { padding: 36px 40px 32px; }

        /* ── Header ───────────────────────────────────── */
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px; }
        .brand { display: flex; align-items: center; gap: 10px; }
        .brand-mark {
            width: 36px; height: 36px; border-radius: 8px;
            background: #0d8a4e; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 15px; letter-spacing: -0.02em;
        }
        .brand-text { line-height: 1.2; }
        .brand-name { font-size: 16px; font-weight: 700; color: #0f172a; letter-spacing: -0.01em; }
        .brand-tagline { font-size: 9px; color: #94a3b8; letter-spacing: 0.04em; text-transform: uppercase; margin-top: 1px; }
        .header-right { text-align: right; }

        /* ── Status badge ─────────────────────────────── */
        .status {
            display: inline-block; padding: 4px 14px; border-radius: 999px;
            font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em;
            color: {{ $statusColor }};
            background: {{ $statusBg }};
            border: 1px solid {{ $statusBorder }};
        }

        /* ── Title block ──────────────────────────────── */
        .title-block { margin-bottom: 4px; }
        .doc-title {
            font-size: 28px; font-weight: 700; color: #0d8a4e;
            letter-spacing: -0.02em; line-height: 1;
        }
        .doc-number { font-size: 11px; color: #64748b; margin-top: 4px; }

        /* ── Divider ──────────────────────────────────── */
        .divider { height: 2px; background: linear-gradient(90deg, #0d8a4e 0%, #0d8a4e 48%, transparent 100%); margin: 20px 0; border-radius: 1px; }

        /* ── Info grid ─────────────────────────────────── */
        .info-grid { display: flex; gap: 0; margin-bottom: 24px; }
        .info-col { flex: 1; }
        .info-col + .info-col { padding-left: 24px; }
        .info-label {
            font-size: 8.5px; text-transform: uppercase; letter-spacing: 0.09em;
            color: #94a3b8; font-weight: 600; margin-bottom: 4px;
        }
        .info-value { font-size: 12px; font-weight: 600; color: #1e293b; }
        .info-meta { font-size: 10px; color: #64748b; margin-top: 1px; }

        /* ── Line items table ──────────────────────────── */
        .items { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        .items thead th {
            text-align: left; font-size: 8.5px; text-transform: uppercase; letter-spacing: 0.09em;
            color: #64748b; font-weight: 600; padding: 8px 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        .items thead th:last-child { text-align: right; }
        .items tbody td {
            padding: 12px 10px; border-bottom: 1px solid #f1f5f9;
            vertical-align: top;
        }
        .items tbody td:last-child { text-align: right; font-weight: 600; }
        .item-name { font-weight: 600; color: #0f172a; }
        .item-note { font-size: 9.5px; color: #94a3b8; margin-top: 2px; }

        /* ── Totals ────────────────────────────────────── */
        .totals-wrap { display: flex; justify-content: flex-end; }
        .totals { width: 240px; border-collapse: collapse; }
        .totals td { padding: 5px 0; font-size: 10.5px; }
        .totals td:first-child { color: #64748b; }
        .totals td:last-child { text-align: right; font-weight: 500; }
        .totals .total-row td {
            padding-top: 10px; border-top: 2px solid #0d8a4e;
            font-size: 14px; font-weight: 700; color: #0d8a4e;
        }

        /* ── Footer ────────────────────────────────────── */
        .footer {
            margin-top: 32px; padding-top: 14px;
            border-top: 1px solid #e2e8f0;
            text-align: center; font-size: 8.5px; color: #94a3b8;
            letter-spacing: 0.02em;
        }

        /* ── Notes section ─────────────────────────────── */
        .notes {
            margin-top: 20px; padding: 12px 14px;
            background: #f8fafc; border-radius: 6px;
            border-left: 3px solid #0d8a4e;
        }
        .notes-label { font-size: 8.5px; text-transform: uppercase; letter-spacing: 0.09em; color: #94a3b8; font-weight: 600; margin-bottom: 4px; }
        .notes-text { font-size: 10px; color: #475569; line-height: 1.5; }
    </style>
</head>
<body>
    <div class="page">
        {{-- Header --}}
        <div class="header">
            <div class="brand">
                <div class="brand-mark">SF</div>
                <div class="brand-text">
                    <div class="brand-name">SmartFarm</div>
                    <div class="brand-tagline">Smart agriculture management</div>
                </div>
            </div>
            <div class="header-right">
                <div class="status">{{ strtoupper($invoice->status) }}</div>
            </div>
        </div>

        {{-- Title --}}
        <div class="title-block">
            <div class="doc-title">INVOICE</div>
            <div class="doc-number">{{ $invoice->invoice_number }}</div>
        </div>

        <div class="divider"></div>

        {{-- Info grid --}}
        <div class="info-grid">
            <div class="info-col">
                <div class="info-label">Billed from</div>
                <div class="info-value">{{ $farm?->name ?? 'SmartFarm' }}</div>
                @if ($farm?->email)
                    <div class="info-meta">{{ $farm->email }}</div>
                @endif
            </div>
            <div class="info-col">
                <div class="info-label">Billed to</div>
                <div class="info-value">{{ $invoice->customer_name ?? '—' }}</div>
            </div>
            <div class="info-col">
                <div class="info-label">Invoice date</div>
                <div class="info-value">{{ $invoice->date->format('d M Y') }}</div>
            </div>
            <div class="info-col">
                <div class="info-label">Due date</div>
                <div class="info-value">{{ $invoice->due_date?->format('d M Y') ?? '—' }}</div>
            </div>
        </div>

        {{-- Line items --}}
        <table class="items">
            <thead>
                <tr>
                    <th style="width:8%">#</th>
                    <th>Description</th>
                    <th style="width:18%">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        <div class="item-name">
                            {{ $invoice->notes ?: ($invoice->finance?->description ?: $invoice->finance?->source ?: 'Invoice line item') }}
                        </div>
                        @if ($invoice->finance_id)
                            <div class="item-note">Linked to transaction #{{ $invoice->finance_id }}</div>
                        @endif
                    </td>
                    <td>KSh {{ number_format((float) $invoice->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="totals-wrap">
            <table class="totals">
                <tr>
                    <td>Subtotal</td>
                    <td>KSh {{ number_format((float) $invoice->amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total due</td>
                    <td>KSh {{ number_format((float) $invoice->amount, 2) }}</td>
                </tr>
            </table>
        </div>

        {{-- Notes --}}
        @if ($invoice->notes)
            <div class="notes">
                <div class="notes-label">Notes</div>
                <div class="notes-text">{{ $invoice->notes }}</div>
            </div>
        @endif

        {{-- Footer --}}
        <div class="footer">
            Generated with SmartFarm &middot; {{ $invoice->invoice_number }} &middot; {{ now()->format('d M Y H:i') }}
        </div>
    </div>
</body>
</html>
