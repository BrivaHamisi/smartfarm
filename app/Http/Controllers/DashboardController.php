<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cattle;
use App\Models\Financial;
use App\Models\Poultry;
use App\Models\Worker;
use App\Models\Calf;
use App\Models\Insemination;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $cattle = Cattle::with([
            'milkProductions' => fn($query) => $query->whereIn('date', [today(), today()->subDay()])
        ])->get();

        $milkToday = $cattle->sum(function ($cow) {
            return $cow->milkProductions->where('date', today())->sum('morning') +
                   $cow->milkProductions->where('date', today())->sum('afternoon') +
                   $cow->milkProductions->where('date', today())->sum('evening');
        });
        $morningMilk = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today())->sum('morning'));
        $afternoonMilk = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today())->sum('afternoon'));
        $eveningMilk = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today())->sum('evening'));

        $yesterdayMorning = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today()->subDay())->sum('morning'));
        $yesterdayAfternoon = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today()->subDay())->sum('afternoon'));
        $yesterdayEvening = $cattle->sum(fn($cow) => $cow->milkProductions->where('date', today()->subDay())->sum('evening'));

        $morningChange = $yesterdayMorning ? round((($morningMilk - $yesterdayMorning) / $yesterdayMorning) * 100, 1) : 0;
        $afternoonChange = $yesterdayAfternoon ? round((($afternoonMilk - $yesterdayAfternoon) / $yesterdayAfternoon) * 100, 1) : 0;
        $eveningChange = $yesterdayEvening ? round((($eveningMilk - $yesterdayEvening) / $yesterdayEvening) * 100, 1) : 0;

        $eggsToday = Poultry::where('date', today())->sum('eggs_produced');
        $activeCows = Cattle::where('gender', 'female')->count();
        $newCows = Cattle::where('created_at', '>=', now()->subMonth())->count();
        $dueInseminations = Insemination::where('successful', null)->where('date', '<=', now())->count();

        $tasks = Insemination::where('successful', null)
            ->where('date', '<=', now()->addDay())
            ->get()
            ->map(fn($i) => [
                'title' => 'Insemination Due',
                'details' => "Cow #{$i->cow_id}",
                'urgent' => $i->date->isToday()
            ]);

        $recentRecords = collect([
            (object) ['id' => 'COW245', 'category' => 'Milk Production', 'details' => "Morning: {$morningMilk}L", 'date' => now()->toDateTimeString(), 'status' => 'Recorded'],
            (object) ['id' => 'PLT001', 'category' => 'Poultry', 'details' => "Eggs: {$eggsToday}", 'date' => now()->toDateTimeString(), 'status' => 'Recorded'],
        ]);

        return view('dashboard', compact(
            'milkToday', 'eggsToday', 'activeCows', 'newCows', 'dueInseminations',
            'morningMilk', 'afternoonMilk', 'eveningMilk',
            'morningChange', 'afternoonChange', 'eveningChange',
            'tasks', 'recentRecords'
        ));
    }
}
