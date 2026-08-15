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
        .title { font-size: 24px; font-weight: 700; color: #0d8a4e; margin: 20px 0 4px; }
        .meta { color: #6b7280; }
        .rule { height: 2px; background: #0d8a4e; margin: 16px 0; border-radius: 2px; }
        .label { font-size: 9px; text-transform: uppercase; letter-spacing: 0.08em; color: #9ca3af; margin-bottom: 3px; }
        .value { font-size: 12px; font-weight: 600; }
        .stats { width: 100%; border-collapse: separate; border-spacing: 6px 0; margin-top: 4px; }
        .stats td {
            width: 25%; background: #f0fdf4; border: 1px solid #dcfce7;
            border-radius: 8px; padding: 12px; vertical-align: top;
        }
        .stats .num { font-size: 17px; font-weight: 700; color: #0d8a4e; margin-top: 2px; }
        .stats td.expense { background: #fef2f2; border-color: #fee2e2; }
        .stats td.expense .num { color: #dc2626; }
        .stats td.neutral { background: #f8fafc; border-color: #e2e8f0; }
        .stats td.neutral .num { color: #334155; }
        h2 { font-size: 12px; text-transform: uppercase; letter-spacing: 0.08em; color: #374151; margin: 20px 0 8px; }
        table.items { width: 100%; border-collapse: collapse; }
        table.items th {
            text-align: left; font-size: 9px; text-transform: uppercase; letter-spacing: 0.08em;
            color: #6b7280; padding: 7px 8px; border-bottom: 2px solid #e5e7eb;
        }
        table.items td { padding: 8px; border-bottom: 1px solid #f3f4f6; }
        table.cats { width: 100%; border-collapse: collapse; }
        table.cats td { padding: 4px 8px; border-bottom: 1px solid #f3f4f6; }
        .foot { margin-top: 26px; padding-top: 14px; border-top: 1px solid #e5e7eb; color: #9ca3af; font-size: 9px; text-align: center; }
        .ok { color: #16a34a; font-weight: 600; }
        .bad { color: #dc2626; font-weight: 600; }
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
        <div>
            <div class="label">Reporting period</div>
            <div class="value">{{ $report['from']->format('d M Y') }} — {{ $report['to']->format('d M Y') }}</div>
        </div>
    </div>

    <div class="title">FARM REPORT</div>
    <div class="meta">{{ $farm?->name }} · {{ $farm?->email ?? '' }}</div>

    <div class="rule"></div>

    <table class="stats">
        <tr>
            <td>
                <div class="label">Total income</div>
                <div class="num">KSh {{ number_format($report['income']) }}</div>
            </td>
            <td class="expense">
                <div class="label">Total expenses</div>
                <div class="num">KSh {{ number_format($report['expense']) }}</div>
            </td>
            <td>
                <div class="label">Net income</div>
                <div class="num">{{ $report['net'] >= 0 ? '' : '−' }}KSh {{ number_format(abs($report['net'])) }}</div>
            </td>
            <td class="neutral">
                <div class="label">Milk yield</div>
                <div class="num">{{ number_format($report['milkYield'], 1) }} L</div>
            </td>
        </tr>
    </table>

    @if (count($report['recentTransactions']))
        <h2>Financial summary by category</h2>
        <table class="cats">
            @foreach ($categories as $category)
                @php
                    $in = $report['incomeByCategory'][$category] ?? 0;
                    $out = $report['expenseByCategory'][$category] ?? 0;
                @endphp
                @if ($in || $out)
                    <tr>
                        <td style="width:40%">{{ ucwords(str_replace('_', ' ', $category)) }}</td>
                        <td class="ok">+ KSh {{ number_format($in) }}</td>
                        <td class="bad">− KSh {{ number_format($out) }}</td>
                        <td style="text-align:right">{{ $in - $out >= 0 ? '+' : '−' }} KSh {{ number_format(abs($in - $out)) }}</td>
                    </tr>
                @endif
            @endforeach
        </table>

        <h2>Recent transactions</h2>
        <table class="items">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Source</th>
                    <th style="text-align:right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($report['recentTransactions']->take(20) as $transaction)
                    <tr>
                        <td>{{ $transaction->date->format('d M Y') }}</td>
                        <td class="{{ $transaction->type === 'income' ? 'ok' : 'bad' }}">{{ ucfirst($transaction->type) }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $transaction->category)) }}</td>
                        <td>{{ $transaction->source ?: '—' }}</td>
                        <td style="text-align:right">{{ $transaction->type === 'income' ? '+' : '−' }} KSh {{ number_format($transaction->amount) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h2>Financial summary</h2>
        <p>No financial transactions were recorded in this period.</p>
    @endif

    <h2>Farm activity in period</h2>
    <table class="items">
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
                    <td style="font-weight:600">{{ $rightKey === 'eggs_produced' ? number_format($report['eggs']) : number_format($report['counts'][$leftKey] ?? 0) }}</td>
                    <td>{{ $rightLabel }}</td>
                    <td style="font-weight:600">{{ $rightKey && $rightKey !== 'eggs_produced' ? number_format($report['counts'][$rightKey] ?? 0) : '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="foot">
        Generated with SmartFarm · {{ $farm?->name ?? 'Farm' }} · {{ now()->format('d M Y H:i') }}
    </div>
</body>
</html>
