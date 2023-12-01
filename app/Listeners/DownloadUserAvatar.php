<?php

namespace App\Listeners;

use App\Events\CreatedUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class DownloadUserAvatar implements ShouldQueue
{
    public string $queue ='avatars';
    public string $connection ='database';

    //TRUC DU PROF
    private function downloadAvatar(string $name): bool
    {
        $url = "https://ui-avatars.com/api/?name=" . urlencode($name);

        $avatar = file_get_contents($url);

        return Storage::put("avatars/{$name}.png", $avatar);
    }

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
        $this->downloadAvatar($event->nom);
    }
}
