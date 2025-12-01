<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Carbon\Carbon;

class MarkPastBookingsAsCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:mark-past-completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark past approved bookings as completed.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $updatedRows = Booking::where('end_time', '<', Carbon::now())
                              ->where('status', 'approved') // Only update approved bookings
                              ->where('status', '!=', 'completed') // Don't re-update
                              ->update(['status' => 'completed']);

        $this->info("{$updatedRows} past approved bookings marked as completed.");
    }
}
