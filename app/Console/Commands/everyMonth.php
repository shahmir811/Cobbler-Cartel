<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\{Log, DailyExpense, Order, Status, CompleteOrder};
use Illuminate\Console\Command;

class everyMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove 03 months old records from daily_expenses and logs tables. Also move 03 months old orders from orders table to completed_orders table';

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
        DailyExpense::where("created_at", '<=', Carbon::now()->subMonths(3))->delete();
        Log::where("created_at", '<=', Carbon::now()->subMonths(3))->delete();

        // move 03 months old finished records to completed orders table
        $finishedId = Status::where('name', '=', 'finished')->pluck('id')->first();
        $orders = Order::where("created_at", '<=', Carbon::now()->subMonths(3))
                        ->where('statuses_id', '=', $finishedId)
                        ->get();
        
        $completeOrder = new CompleteOrder;
        foreach ($orders as $order) {
            $completeOrder->insertRecord($order);
            $order->delete();
        }

        // echo Carbon::now()->subMonths(3);
        // echo $orders[0];
        return 0;
    }
}
