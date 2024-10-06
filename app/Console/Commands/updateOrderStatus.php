<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;


class updateOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-order-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Orders will be valid for 1 day and orders that are not confirmed within this period will be automatically rejected.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $orders = Order::where('status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subDay())
            ->get();

        foreach ($orders as $order) {
            $order->update(['status' => 'rejected']);
        }

    }
}
