<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeleteOldGuestUsers extends Command
{
    protected $signature = 'users:delete-old-guests';
    protected $description = 'Delete guest users older than 5 days';

    public function handle()
    {
        Log::info("Starting DeleteOldGuestUsers command...");
        $this->info("Starting command...");
        $threshold = Carbon::now()->subDays(5);
        Log::info("Threshold: $threshold");
        $this->info("Threshold: $threshold");
        $users = User::where('is_guest', true)->where('created_at', '<', $threshold)->get();
        Log::info("Found users count: " . $users->count());
        $this->info("Found users count: " . $users->count());
        Log::info("Found users: " . $users->toJson());
        $this->info("Found users: " . $users->toJson());
        $count = User::where('is_guest', true)->where('created_at', '<', $threshold)->delete();
        Log::info("Deleted $count guest users.");
        $this->info("Deleted $count guest users.");

        \Illuminate\Support\Facades\DB::table('sessions')
            ->where('last_activity', '<', now()->subDays(5)->timestamp)
            ->delete();
        Log::info("Deleted old sessions.");
        $this->info("Deleted old sessions.");
    }
}
