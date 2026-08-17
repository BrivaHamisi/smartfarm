@php
    $farm = $report['farm'];
    $categories = ['feeds', 'medication', 'human_resource', 'sales', 'dorper', 'crops', 'rabbits', 'other'];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Farm Report — {{ $farm?->name }}</title>
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

        /* ── Period badge ─────────────────────────────── */
        .period {
            display: inline-block; padding: 4px 14px; border-radius: 999px;
            font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em;
            color: #0d8a4e; background: #f0fdf4; border: 1px solid #bbf7d0;
        }

        /* ── Title block ──────────────────────────────── */
        .title-block { margin-bottom: 4px; }
        .doc-title {
            font-size: 26px; font-weight: 700; color: #0d8a4e;
            letter-spacing: -0.02em; line-height: 1;
        }
        .doc-meta { font-size: 10.5px; color: #64748b; margin-top: 4px; }

        /* ── Divider ──────────────────────────────────── */
        .divider { height: 2px; background: linear-gradient(90deg, #0d8a4e 0%, #0d8a4e 48%, transparent 100%); margin: 20px 0; border-radius: 1px; }

        /* ── Stat cards ────────────────────────────────── */
        .stats { width: 100%; border-collapse: separate; border-spacing: 6px 0; margin-bottom: 24px; }
        .stats td {
            width: 25%; border-radius: 8px; padding: 14px 12px; vertical-align: top;
        }
        .stat-label { font-size: 8.5px; text-transform: uppercase; letter-spacing: 0.09em; color: #94a3b8; font-weight: 600; margin-bottom: 4px; }
        .stat-num { font-size: 17px; font-weight: 700; line-height: 1.1; }
        .stats td.income { background: #f0fdf4; border: 1px solid #dcfce7; }
        .stats td.income .stat-num { color: #0d8a4e; }
        .stats td.expense { background: #fef2f2; border: 1px solid #fee2e2; }
        .stats td.expense .stat-num { color: #dc2626; }
        .stats td.net { background: #f0fdf4; border: 1px solid #dcfce7; }
        .stats td.net .stat-num { color: #0d8a4e; }
        .stats td.neutral { background: #f8fafc; border: 1px solid #e2e8f0; }
        .stats td.neutral .stat-num { color: #334155; }

        /* ── Section headings ──────────────────────────── */
        .section-title {
            font-size: 10px; text-transform: uppercase; letter-spacing: 0.09em;
            color: #475569; font-weight: 700; margin: 24px 0 10px;
            padding-bottom: 6px; border-bottom: 1px solid #e2e8f0;
        }

        /* ── Tables ────────────────────────────────────── */
        table.data { width: 100%; border-collapse: collapse; }
        table.data th {
            text-align: left; font-size: 8.5px; text-transform: uppercase; letter-spacing: 0.09em;
            color: #64748b; font-weight: 600; padding: 7px 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        table.data th:last-child, table.data td:last-child { text-align: right; }
        table.data td { padding: 9px 10px; border-bottom: 1px solid #f1f5f9; font-size: 10.5px; }

        /* ── Category summary ──────────────────────────── */
        table.cats { width: 100%; border-collapse: collapse; }
        table.cats td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; font-size: 10.5px; }
        table.cats td:last-child { text-align: right; font-weight: 600; }
        .amount-pos { color: #0d8a4e; font-weight: 600; }
        .amount-neg { color: #dc2626; font-weight: 600; }
        .amount-neutral { color: #475569; font-weight: 500; }

        /* ── Footer ────────────────────────────────────── */
        .footer {
            margin-top: 32px; padding-top: 14px;
            border-top: 1px solid #e2e8f0;
            text-align: center; font-size: 8.5px; color: #94a3b8;
            letter-spacing: 0.02em;
        }
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
                <div class="period">Reporting period</div>
                <div style="margin-top:6px; font-size:11px; font-weight:600; color:#1e293b;">
                    {{ $report['from']->format('d M Y') }} &mdash; {{ $report['to']->format('d M Y') }}
                </div>
            </div>
        </div>

        {{-- Title --}}
        <div class="title-block">
            <div class="doc-title">FARM REPORT</div>
            <div class="doc-meta">{{ $farm?->name }} &middot; {{ $farm?->email ?? '' }}</div>
        </div>

        <div class="divider"></div>

        {{-- Stats --}}
        <table class="stats">
            <tr>
                <td class="income">
                    <div class="stat-label">Total income</div>
                    <div class="stat-num">KSh {{ number_format($report['income']) }}</div>
                </td>
                <td class="expense">
                    <div class="stat-label">Total expenses</div>
                    <div class="stat-num">KSh {{ number_format($report['expense']) }}</div>
                </td>
                <td class="net">
                    <div class="stat-label">Net income</div>
                    <div class="stat-num">{{ $report['net'] >= 0 ? '' : '&minus;' }}KSh {{ number_format(abs($report['net'])) }}</div>
                </td>
                <td class="neutral">
                    <div class="stat-label">Milk yield</div>
                    <div class="stat-num">{{ number_format($report['milkYield'], 1) }} L</div>
                </td>
            </tr>
        </table>

        {{-- Financial summary --}}
        @if (count($report['recentTransactions']))
            <div class="section-title">Financial summary by category</div>
            <table class="cats">
                @foreach ($categories as $category)
                    @php
                        $in = $report['incomeByCategory'][$category] ?? 0;
                        $out = $report['expenseByCategory'][$category] ?? 0;
                    @endphp
                    @if ($in || $out)
                        <tr>
                            <td style="width:40%; font-weight:500;">{{ ucwords(str_replace('_', ' ', $category)) }}</td>
                            <td class="amount-pos">+ KSh {{ number_format($in) }}</td>
                            <td class="amount-neg">&minus; KSh {{ number_format($out) }}</td>
                            <td class="{{ $in - $out >= 0 ? 'amount-pos' : 'amount-neg' }}">
                                {{ $in - $out >= 0 ? '+' : '&minus;' }} KSh {{ number_format(abs($in - $out)) }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>

            <div class="section-title">Recent transactions</div>
            <table class="data">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Source</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($report['recentTransactions']->take(20) as $transaction)
                        <tr>
                            <td>{{ $transaction->date->format('d M Y') }}</td>
                            <td class="{{ $transaction->type === 'income' ? 'amount-pos' : 'amount-neg' }}">{{ ucfirst($transaction->type) }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $transaction->category)) }}</td>
                            <td>{{ $transaction->source ?: '—' }}</td>
                            <td class="{{ $transaction->type === 'income' ? 'amount-pos' : 'amount-neg' }}">
                                {{ $transaction->type === 'income' ? '+' : '&minus;' }} KSh {{ number_format($transaction->amount) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="section-title">Financial summary</div>
            <p style="color:#64748b; padding:8px 0;">No financial transactions were recorded in this period.</p>
        @endif

        {{-- Activity --}}
        <div class="section-title">Farm activity in period</div>
        <table class="data">
            <thead>
                <tr>
                    <th>Area</th>
                    <th>Records</th>
                    <th>Area</th>
                    <th>Records</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $pairs = [
                        ['Cattle added', 'cattle', 'Calves born', 'calves'],
                        ['Milk records', 'milk_records', 'Eggs produced', 'eggs_produced'],
                        ['Inseminations', 'inseminations', 'Checkups', 'checkups'],
                        ['Poultry records', 'poultry_records', 'Workers added', 'workers'],
                        ['Dorper animals', 'dorper_animals', 'Dorper breedings', 'dorper_breedings'],
                        ['Crop fields planted', 'crop_fields', 'Crop inputs', 'crop_inputs'],
                        ['Crop harvests', 'crop_harvests', 'Rabbits added', 'rabbits'],
                        ['Rabbit breedings', 'rabbit_breedings', '', ''],
                    ];
                @endphp
                @foreach ($pairs as [$leftLabel, $leftKey, $rightLabel, $rightKey])
                    <tr>
                        <td>{{ $leftLabel }}</td>
                        <td style="font-weight:600;">{{ $rightKey === 'eggs_produced' ? number_format($report['eggs']) : number_format($report['counts'][$leftKey] ?? 0) }}</td>
                        <td>{{ $rightLabel }}</td>
                        <td style="font-weight:600;">{{ $rightKey && $rightKey !== 'eggs_produced' ? number_format($report['counts'][$rightKey] ?? 0) : '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Footer --}}
        <div class="footer">
            Generated with SmartFarm &middot; {{ $farm?->name ?? 'Farm' }} &middot; {{ now()->format('d M Y H:i') }}
        </div>
    </div>
</body>
</html>
