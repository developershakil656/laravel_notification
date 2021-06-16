<?php

namespace App\Listeners;

use App\Models\Admin;
use App\Notifications\NewUserAdminNotify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NewUserAdmin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $admins = Admin::all();

        
        Notification::send($admins, new NewUserAdminNotify($event->user));

        // foreach($admins as $admin){
        //     // $admin->notify(new NewUserAdminNotify($this->user));
        //     Notification::send($admins, new NewUserAdminNotify($this->user));
        // }
    }
}
