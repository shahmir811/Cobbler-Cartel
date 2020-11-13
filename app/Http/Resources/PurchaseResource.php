<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'total_amount' => number_format($this->total_amount, 2),
            'item_id' => $this->item_id,
            'item_name' => $this->item->name,
            'created_at' => date('d M Y', strtotime($this->created_at)),
        ];
    }
}
