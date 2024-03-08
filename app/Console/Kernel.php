<?php

namespace App\Console;

use App\Models\MedicineDetails;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // to mark expired medicines
        $schedule->call(function () {
            $medicines = MedicineDetails::where('expiry_date', '<' , now())->where('is_expired', 0)->get();
            foreach($medicines as $medicine) {
                $medicine->is_expired = true;
                $medicine->expired_price = $medicine->price;
                $medicine->save();
            }
        })->everyFiveSeconds();

        // to delete password_reset_tokens
        $schedule->command('auth:clear-resets')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
