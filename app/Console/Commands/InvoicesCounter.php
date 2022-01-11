<?php

namespace App\Console\Commands;

use App\Repository;
use Illuminate\Console\Command;

class InvoicesCounter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:counter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make all repositories invoices code start from 1 again';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $repositories = Repository::all();
        foreach($repositories as $repository){
            if($repository->setting){
                $setting = $repository->setting;
                $setting->update([
                    'invoices_count_today' => 0,
                ]);
            }
        }
    }
}
