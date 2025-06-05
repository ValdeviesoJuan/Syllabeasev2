<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\role_user;
use App\Models\UserRole;

class CreateUserRole
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $role = new UserRole();
        $role->user_id = $event->user->id;
        $role->role_id = '5';//set default role as Bayanihan Teachers-5
        $role->save();
    }
}
