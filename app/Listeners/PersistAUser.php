<?php

namespace App\Listeners;

use App\Events\CreatedUser;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PersistAUser
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
     * @param  \App\Events\CreatedUser  $event
     * @return void
     */
    public function handle(CreatedUser $event)
    {
        $user = User::query()->create([
            'name' => $event->nom,
            'email' => $event->email,
            'role' => $event->role
        ]);
    }
}
