<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['order_date'];

    public function status()
    {
        return $this->belongsTo(Status::class, 'statuses_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (Order $order) {
            $order->order_dispatch_date = date('Y-m-d', strtotime($order->order_date. ' + 7 days'));
        });
    }

    public function noOfDays($comingDate)
    {
        $orderDispatchDate = new DateTime($comingDate);
        $todayDate = now();

        $diff = 0;

        if($orderDispatchDate >= $todayDate) {
            $diff = $todayDate->diff($orderDispatchDate)->format("%a");
        }


        return $diff;
    }

}
