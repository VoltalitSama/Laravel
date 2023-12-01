<?php

namespace App\Listeners;

use App\Events\CreatedUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAWelcomeEmail implements ShouldQueue
{

    public string $queue = 'mails';
    public string $connection = 'database';

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
        Mail::raw("Bravo {$event->nom}, vous faites maintenant partie de notre programme de fidélité !", function (Message $message) use ($event) {
            $message->to($event->email, $event->nom)
                ->subject('Bienvenue chez nous !');
        });
    }
}
