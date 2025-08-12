<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteOldGuestUsers extends Command
{
    protected $signature = 'users:delete-old-guests';
    protected $description = 'Delete guest users older than 5 days';

    public function handle()
    {
        $threshold = Carbon::now()->subDays(5);
        $users = User::where('is_guest', true)->where('created_at', '<', $threshold)->get();
        $count = User::where('is_guest', true)->where('created_at', '<', $threshold)->delete();
        $this->info("Threshold: $threshold");
        $this->info("Found users: " . $users->toJson());
        $this->info("Deleted $count guest users.");
    }
}
