<?php

namespace App\Console\Commands;

use App\Jobs\readCSV;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ProcessCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:csv {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch le job';

    /**
     * Execute the console command.
     *
     *
     * @return int
     */
    public function handle(): int
    {
        //Dispatch job dans queue file_processing
        readCSV::dispatch(storage_path($this->argument("path")))->onQueue('file_processing');

        $this->info('Job dispatched successfully.');

        return CommandAlias::SUCCESS;
    }
}
