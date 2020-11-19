<?php

namespace App\Console\Commands;

use App\Models\{Message};
use Illuminate\Console\Command;

class everyHour extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hourly:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send sms to clients by an hour';

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
        $messages = Message::where('status', '=', 0)->get();
        foreach ($messages as $message) {
            $contact_number = '92' . substr($message->phone_number, 1);
            echo "Send SMS to number: " . $contact_number;
            $message->status = 1;
            $message->save();
        }
        // echo "Send SMS to clients Hourly";
        return 0;
    }
}
