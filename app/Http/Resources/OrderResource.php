<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_no' => $this->order_no,
            'order_date' => date("d M Y", strtotime($this->order_date)),
            'order_time' => $this->order_time,
            'order_received_at' => date("d M Y H:i A", strtotime($this->order_received_at)),
            'order_dispatch_date' => date("d M Y", strtotime($this->order_dispatch_date)),
            'days_left' => $this->noOfDays($this->order_dispatch_date),
            'billing_customer' => $this->billing_customer,
            'billing_company_name' => $this->billing_company_name,
            'billing_country' => $this->billing_country,
            'billing_state' => $this->billing_state,
            'billing_city' => $this->billing_city,
            'billing_address' => $this->billing_address,
            'billing_zip_code' => $this->billing_zip_code,
            
            'delivery_customer' => $this->delivery_customer,
            'delivery_company_name' => $this->delivery_company_name,
            'delivery_country' => $this->delivery_country,
            'delivery_state' => $this->delivery_state,
            'delivery_city' => $this->delivery_city,
            'delivery_address' => $this->delivery_address,
            'delivery_zip_code' => $this->delivery_zip_code,

            'buyer_phone' => $this->buyer_phone,
            'shipping_label' => $this->shipping_label,
            'buyer_email' => $this->buyer_email,
            'delivery_method' => $this->delivery_method,
            'item_name' => $this->item_name,
            'item_variant' => $this->item_variant,
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'item_price' => number_format($this->item_price, 2),
            'item_weight' => number_format($this->item_weight, 2),
            'item_custom_text' => $this->item_custom_text,
            'coupon' => $this->coupon,
            'notes_to_seller' => $this->notes_to_seller,
            'shipping' => $this->shipping,
            'tax' => $this->tax,
            'gift_card' => $this->gift_card,
            'total' => number_format($this->total, 2),
            'currency' => $this->currency,
            'payment_mentod' => $this->payment_mentod,
            'payment' => $this->payment,
            'fulfillment' => $this->fulfillment,
            'refund' => $this->refund,
            'total_after_refund' => number_format($this->total_after_refund, 2),
            'quantity_refunded' => $this->quantity_refunded,
            'quatity_restocked' => $this->quatity_restocked,
            'additional_info' => $this->additional_info,
            'created_at' => $this->created_at,
            'operated_by' => $this->user->name,
            'status' => $this->status->name,
            'tableName' => $this->getTable()

        ];
    }
}
