<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Validator;

class readCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public string $linkCSV
    )
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //dd($this->linkCSV);
        // Ouvrir le fichier
        $usersCSV = $this->readCsv($this->linkCSV);

        //Validator d'email
        // Validator d'email
        $validator = Validator::make([], []); // Validator vide pour l'instant



        // Si on arrive à Open le fichier
        if ($usersCSV) {
            $users = User::query();
            $users->truncate();

            foreach ($usersCSV as $data) {
                $validator = Validator::make(['email' => $data[1]], [
                    'email' => 'required|email',
                ]);
                // Si la validation échoue, vous pouvez gérer les erreurs ici
                if(!$validator->fails()) {
                    $user = User::create([
                        'email' => $data[1],
                        'name' => $data[0]
                    ]);
                }
            }
        } else {
            // Gérer les erreurs si le fichier ne peut pas être ouvert
            echo "Impossible d'ouvrir le fichier CSV, ou aucune donnée.";
        }

    }
    private function readCsv(string $path): array
    {
        $file = fopen($path, 'r');
        $data = [];
        while (($line = fgetcsv($file)) !== false) {
            $data[] = $line;
        }
        fclose($file);
        return $data;
    }
}
