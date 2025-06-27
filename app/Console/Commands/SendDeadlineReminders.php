<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Deadline;
use App\Models\User;
use App\Notifications\DeadlineSetNotification;
use Carbon\Carbon;

class SendDeadlineReminders extends Command
{
    protected $signature = 'deadline:reminders';
    protected $description = 'Send notifications 3 days before and on deadline day';

    public function handle()
    {
        $today = Carbon::today();
        $inThreeDays = $today->copy()->addDays(3);

        $deadlines = Deadline::whereIn('dl_syll', [$inThreeDays, $today])->get();

        foreach ($deadlines as $deadline) {
            $type = $deadline->dl_syll == $inThreeDays ? '3_days_before' : 'due_today';

            $leaders = User::whereHas('roles', fn($q) => $q->where('user_roles.role_id', 4))->get();

            foreach ($leaders as $bl) {
                $bl->notify(new DeadlineSetNotification($deadline, $type));
            }
        }

        $this->info("Reminders sent.");
    }
}
