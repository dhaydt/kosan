<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CancelCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle()
    {
        $check = \App::call('App\Http\Controllers\Admin\OrderController@checkStatus');
        \Log::info($check);
    }
}
