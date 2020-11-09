<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function inventories() {
        return $this->hasMany(Inventory::class);
    }

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (Item $item) {
            $item->item_code = time() . 'i';
        });
    }

}
