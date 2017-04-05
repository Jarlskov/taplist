<?php

namespace App\Console\Commands;

use App\TaplistService;

use Illuminate\Console\Command;

class UpdateTaplistingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listings:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update tap listings';

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
     * @return mixed
     */
    public function handle(TaplistService $service)
    {
        $service->updateTaplists();
    }
}
