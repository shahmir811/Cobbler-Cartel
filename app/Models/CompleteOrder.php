<?php

namespace App\Models;

use Auth;
use App\Models\{Order, Status};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompleteOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function status()
    {
        return $this->belongsTo(Status::class, 'statuses_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function insertRecord(Order $order)
    {
        $completeStatusId = Status::where('name', '=', 'finished')->pluck('id')->first();

        $orderData = [
            'order_no' => $order->order_no,
            'order_date' => $order->order_date,
            'order_time' => $order->order_time,
            'order_dispatch_date' => $order->order_dispatch_date,
            'order_received_at' => $order->order_received_at,
            'billing_customer' => $order->billing_customer,
            'billing_company_name' => $order->billing_company_name,
            'billing_country' => $order->billing_country,
            'billing_state' => $order->billing_state,
            'billing_city' => $order->billing_city,
            'billing_address' => $order->billing_address,
            'billing_zip_code' => $order->billing_zip_code,
            'delivery_customer' => $order->delivery_customer,
            'delivery_company_name' => $order->delivery_company_name,
            'delivery_country' => $order->delivery_country,
            'delivery_state' => $order->delivery_state,
            'delivery_city' => $order->delivery_city,
            'delivery_address' => $order->delivery_address,
            'delivery_zip_code' => $order->delivery_zip_code,
            'buyer_phone' => $order->buyer_phone,
            'shipping_label' => $order->shipping_label,
            'buyer_email' => $order->buyer_email,
            'delivery_method' => $order->delivery_method,
            'item_name' => $order->item_name,
            'item_variant' => $order->item_variant,
            'sku' => $order->sku,
            'quantity' => $order->quantity,
            'item_price' => $order->item_price,
            'item_weight' => $order->item_weight,
            'item_custom_text' => $order->item_custom_text,
            'coupon' => $order->coupon,
            'notes_to_seller' => $order->notes_to_seller,
            'shipping' => $order->shipping,
            'tax' => $order->tax,
            'gift_card' => $order->gift_card,
            'total' => $order->total,
            'currency' => $order->currency,
            'payment_mentod' => $order->payment_mentod,
            'payment' => $order->payment,
            'fulfillment' => $order->fulfillment,
            'refund' => $order->refund,
            'total_after_refund' => $order->total_after_refund,
            'quantity_refunded' => $order->quantity_refunded,
            'quatity_restocked' => $order->quatity_restocked,
            'additional_info' => $order->additional_info,
            'user_id' => Auth::id(),
            'statuses_id' => $completeStatusId,
        ];

        return $this->create($orderData);
    }
}
