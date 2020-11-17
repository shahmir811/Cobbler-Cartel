<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function insertLog($description, $type, $amount)
    {
        $newLog = [
            'description' => $description,
            'type' => $type,
            'amount' => $amount,
            'user_id' => Auth::id(),
        ];

        return $this->create($newLog);

    }
}
