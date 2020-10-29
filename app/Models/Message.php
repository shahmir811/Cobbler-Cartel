<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
        
    protected $guarded = [];

    public function insertRecord($data)
    {

        $newRecord = $data;
        $newRecord = [
            'type' => $data["type"],
            'description' => $this->getMessageDescriptionBasedOnStatus($data["name"], $data["type"], $data['order_no']),
            'phone_number' => $data["phone_number"]
        ];

        return $this->create($newRecord);
        
    }

    private function getMessageDescriptionBasedOnStatus($name, $statusName, $orderNo)
    {
        $message;

        if($statusName == 'confirmed') {
            $message = 'Dear ' . $name . ', your order ' . $orderNo . ' has been confirmed';

        } else if($statusName == 'upper') {
            $message = 'Dear ' . $name . ', your order ' . $orderNo . ' has been moved to upper part';
        } else if($statusName == 'bottom') {
            $message = 'Dear ' . $name . ', your order ' . $orderNo . ' has been moved to bottom part';
        } else if($statusName == 'finished') {
            $message = 'Dear ' . $name . ', your order ' . $orderNo . ' has been completed';
        } else if($statusName == 'dispatched') {
            $message = 'Dear ' . $name . ', your order ' . $orderNo . ' has been dispatched';
        } else {
            $message = 'Dear ' . $name . ', your order ' . $orderNo . ' has been stocked';
        }

        return $message;
    }

}
