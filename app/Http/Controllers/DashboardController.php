<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Cattle;
use App\Models\Finances;
use App\Models\Insemination;
use App\Models\MilkProduction;
use App\Models\Poultry;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // All queries automatically scoped to farm_owner_id via BelongsToUser trait
        $cattle = Cattle::with([
            'milkProductions' => fn($q) => $q->whereIn('date', [today(), today()->subDay()])
        ])->get();

        $milkToday      = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today())->sum('morning') + $cow->milkProductions->where('date', today())->sum('afternoon') + $cow->milkProductions->where('date', today())->sum('evening'));
        $morningMilk    = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today())->sum('morning'));
        $afternoonMilk  = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today())->sum('afternoon'));
        $eveningMilk    = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today())->sum('evening'));

        $yesterdayMorning   = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today()->subDay())->sum('morning'));
        $yesterdayAfternoon = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today()->subDay())->sum('afternoon'));
        $yesterdayEvening   = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today()->subDay())->sum('evening'));

        $morningChange   = $yesterdayMorning   ? round((($morningMilk   - $yesterdayMorning)   / $yesterdayMorning)   * 100, 1) : 0;
        $afternoonChange = $yesterdayAfternoon ? round((($afternoonMilk - $yesterdayAfternoon) / $yesterdayAfternoon) * 100, 1) : 0;
        $eveningChange   = $yesterdayEvening   ? round((($eveningMilk   - $yesterdayEvening)   / $yesterdayEvening)   * 100, 1) : 0;

        $eggsToday        = Poultry::whereDate('date', today())->sum('eggs_produced');
        $activeCows       = $cattle->where('gender', 'female')->count();
        $newCows          = $cattle->where('created_at', '>=', now()->subMonth())->count();
        $dueInseminations = Insemination::whereNull('successful')->where('date', '<=', now())->count();

        $tasks = Insemination::whereNull('successful')
            ->where('date', '<=', now()->addDay())
            ->get()
            ->map(fn($i) => (object)[
                'title'   => 'Insemination Due',
                'details' => "Cow #{$i->cow_id}",
                'urgent'  => $i->date->isToday(),
            ]);

        // Recent records from real data
        $recentMilk = MilkProduction::with('cow')->latest()->take(3)->get()
            ->map(fn($m) => (object)[
                'id'       => 'MK' . str_pad($m->id, 3, '0', STR_PAD_LEFT),
                'category' => 'Milk Production',
                'details'  => ($m->cow->name ?? 'Cow') . ' — ' . $m->total_yield . 'L',
                'date'     => $m->date->format('d M Y'),
                'status'   => 'Recorded',
            ]);

        $recentFinance = Finances::latest('date')->take(3)->get()
            ->map(fn($f) => (object)[
                'id'       => 'FN' . str_pad($f->id, 3, '0', STR_PAD_LEFT),
                'category' => ucfirst($f->category),
                'details'  => ucfirst($f->type) . ' — KES ' . number_format($f->amount),
                'date'     => $f->date->format('d M Y'),
                'status'   => 'Recorded',
            ]);

        $recentRecords = $recentMilk->merge($recentFinance)->sortByDesc('date')->take(5)->values();

        return view('dashboard', compact(
            'milkToday', 'eggsToday', 'activeCows', 'newCows', 'dueInseminations',
            'morningMilk', 'afternoonMilk', 'eveningMilk',
            'morningChange', 'afternoonChange', 'eveningChange',
            'tasks', 'recentRecords'
        ));
    }
}