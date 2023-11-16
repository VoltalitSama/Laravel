<?php

namespace App\Console\Commands;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {nom} {email} {--r|role=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user with a name and a email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('nom');
        $email = $this->argument('email');
        $role = $this->option('role');

        $roles = collect(Roles::cases())->map->value;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           $this->error("Email non valide");
           return Command::FAILURE;
        }

        $user = User::query()
            ->where('email', $email)->exists();

        if($user) {
            $this->error("L'adresse mail est déjà utilisé");
            return Command::FAILURE;
        }

        if(!$role){
            if($this->confirm("Voulez-vous créer un utilisateur avec le rôle client ?", true)){
                $role = Roles::Client;
            }else{
                $role = $this->choice('Quel est sont rôle ?',[Roles::Client->value, Roles::Admin->value, Roles::SuperAdmin->value]);
            }
        }else {
            if(!$roles->contains($role)) {
                $this->error("Le rôle n'existe pas");
                return Command::FAILURE;
            }
        }

        $user = User::query()->create([
                'name' => $name,
                'email' => $email,
                'role' => $role
            ]);

        $user->sendAuthenticationMail();

        $this->line("Utilisateur créé !");
        return Command::SUCCESS;
    }
}
