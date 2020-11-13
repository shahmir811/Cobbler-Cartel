<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;


    public function item() {
        return $this->belongsTo(Item::class);
    }
    
    public function getTotalAmount($item_id, $quantity) {
        $item = $this->item->where('id', '=', $item_id)->first();
        return $item->price * $quantity;
    }
}
