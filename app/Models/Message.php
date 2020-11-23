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
        if($data["type"] == 'confirmed' || $data["type"] == 'upper' || $data["type"] == 'bottom' || $data["type"] == 'dispatched') {
            
            $newRecord = $data;
            $newRecord = [
                'type' => $data["type"],
                'description' => $this->getMessageDescriptionBasedOnStatus($data["name"], $data["type"], $data['order_no'], $data['product']),
                'phone_number' => $data["phone_number"]
            ];

            return $this->create($newRecord);
        }

        
    }

    private function getMessageDescriptionBasedOnStatus($name, $statusName, $orderNo, $product)
    {
        $message;

        if($statusName == 'confirmed') {
            $message = 'Dear ' . $name . ', your order has been confirmed under product ' . $product . ' and your order number is ' . $orderNo . '. This shoe will be handstitched and will take approximately 8-10 working days to be delivered at your address.';

        } else if($statusName == 'upper') {
            
            $message = 'Dear ' . $name . ', this message is sent to inform you that your shoe is now in the upper stage of the production. Here we make the upper part of the shoe, the craft on the upper layer of the leather and colouring.';

        } else if($statusName == 'bottom') {
            
            $message = 'Dear ' . $name . ', this message is sent to inform you that your shoe is now in its bottom production. Here we make the sole of the shoe along with final touching and finishing.';
        
        } else if($statusName == 'finished') {
            
            $message = 'Dear ' . $name . ', your order ' . $orderNo . ' has been completed';
        
        } else if($statusName == 'dispatched') {
            
            $message = 'Dear ' . $name . ', your shoe has been dispatched. It will reach you in 2-3 working days. Please keep the amount ready to avoid any inconvenience.';
        
        } else {
            $message = 'Dear ' . $name . ', your order ' . $orderNo . ' has been stocked';
        }

        return $message;
    }

}
