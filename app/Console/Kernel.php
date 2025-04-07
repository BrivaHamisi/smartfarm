protected function schedule(Schedule $schedule) {
    $schedule->call(function () {
        // Drying period (2 months before expected DOB)
        $cows = Insemination::whereNotNull('expected_dob')
            ->where('successful', true)
            ->whereDate('expected_dob', '>=', now()->addMonths(2))
            ->get();

        foreach ($cows as $cow) {
            // Send notification (e.g., via email or log)
            \Log::info("Drying period reminder for Cow ID: {$cow->cow_id}");
        }

        // Expected DOB reminders (7 days and 2 days before)
        $nearDob = Insemination::whereNotNull('expected_dob')
            ->whereIn(\DB::raw('DATEDIFF(expected_dob, NOW())'), [7, 2])
            ->get();

        foreach ($nearDob as $cow) {
            \Log::info("DOB reminder for Cow ID: {$cow->cow_id}");
        }

        // Deworming (every 3 months)
        $checkups = Checkup::where('type', 'deworming')
            ->where('date', '<=', now()->subMonths(3))
            ->get();

        foreach ($checkups as $checkup) {
            \Log::info("Deworming reminder for Cow ID: {$checkup->cow_id}");
        }
    })->daily();
}