<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function insertRecord($description, $type, $amount, $reference_id)
    {
        $newRecord = [
            'description' => $description,
            'type' => $type,
            'amount' => $amount,
            'reference_id' => $reference_id
        ];

        return $this->create($newRecord);

    }    
}
