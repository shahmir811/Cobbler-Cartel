<?php

namespace App\Console\Commands;

use App\Models\Message;
use Illuminate\Console\Command;

class everyDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will remove records from messages table whose status = 1';

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
        Message::where('status', '=', 1)->delete();
        return 0;
    }
}
