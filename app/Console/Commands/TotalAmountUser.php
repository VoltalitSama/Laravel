<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class TotalAmountUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:total-amount {--I|id=} {--E|email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Detaille la liste de toutes les factures a d'un utilisateur selon son Id ou Email";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->option('id');
        $email = $this->option('email');
        if (!($id ^ $email)){
            $this->error('Il faut remplir soit la donnée ID, soit la donnée Email, pas les deux, ni aucune');
            return Command::FAILURE;
        }
        else{
            if(($email != null && filter_var($email, FILTER_VALIDATE_EMAIL)) || ($id != null)){
                $invoices = Invoice::query()
                    ->with(['client', 'tools'])
                    ->whereHas('client', function (Builder $query) use ($email) {
                        if ($email) {
                            $this->line($email);
                            $query->where('email', $email);
                        }
                    })
                    ->whereHas('client', function (Builder $query) use ($id) {
                        if ($id) {
                            $this->line($id);
                            $query->where('client_id',$id);
                        }
                    });
                $invoices = $invoices->get();
                $sum_invoices = 0;
                foreach ($invoices as $invoice) {
                    $total_amount = 0;

                    foreach ($invoice->tools as $tool) {
                        $total_amount += $tool->pivot->quantity * $tool->price->getPrice();
                    }

                    $sum_invoices += $total_amount;
                }

                if($invoices->count() == 0){
                    $this->error('No invoices found for this client');
                    return Command::FAILURE;
                }
                $this->line("Somme totale des invoices : " . strval($sum_invoices) ." €");
                $this->info("Command Somme Invoices was successful");
                return  Command::SUCCESS;
            }
            else{
                $this->error('Email ou Id de format non valide');
                return Command::FAILURE;
            }
        }
    }
}
