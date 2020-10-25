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
            'order_date' => $this->order_date,
            'order_time' => $this->order_time,
            'billing_customer' => $this->billing_customer,
            'billing_company_name' => $this->billing_company_name,
            'billing_country' => $this->billing_country,
            'billing_state' => $this->billing_state,
            'billing_city' => $this->billing_city,
            'billing_address' => $this->billing_address,
            'billing_zip_code' => $this->billing_zip_code,
            'buyer_phone' => $this->buyer_phone,
            'shipping_label' => $this->shipping_label,
            'buyer_email' => $this->buyer_email,
            'delivery_method' => $this->delivery_method,
            'item_name' => $this->item_name,
            'item_variant' => $this->item_variant,
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'item_price' => $this->item_price,
            'item_weight' => $this->item_weight,
            'item_custom_text' => $this->item_custom_text,
            'coupon' => $this->coupon,
            'notes_to_seller' => $this->notes_to_seller,
            'shipping' => $this->shipping,
            'tax' => $this->tax,
            'gift_card' => $this->gift_card,
            'total' => $this->total,
            'currency' => $this->currency,
            'payment_mentod' => $this->payment_mentod,
            'payment' => $this->payment,
            'fulfillment' => $this->fulfillment,
            'refund' => $this->refund,
            'total_after_refund' => $this->total_after_refund,
            'quantity_refunded' => $this->quantity_refunded,
            'quatity_restocked' => $this->quatity_restocked,
            'additional_info' => $this->additional_info,
            'created_at' => $this->created_at,
            'operated_by' => $this->user->name,
            'status' => $this->status->name,

        ];
    }
}
