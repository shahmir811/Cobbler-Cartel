<?php

namespace App\Imports;

use Auth;
use DateTime;
use Carbon\Carbon;
use App\Models\{Order, Status};
use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrdersImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {

        $confirm_id = Status::where('name', '=', 'confirmed')->pluck('id')->first();
        // dd($row);

        // We will first check whether the coming Order # is already imported to database or not.
        // if not we will dump the record in database

        if(!Order::where('order_no', '=', $row['order'])->exists()) {

            return new Order([

                "order_no" => $row['order'],
                "order_date" => $row['date'],
                "order_time" => date("H:i:s", strtotime($row["time"])),
                "order_received_at" => $this->combineDateAndTime($row['date'], $row['time']),
                "billing_customer" => $row['billing_customer'],
                "billing_company_name" => $row['billing_company_name'],
                "billing_country" => $row['billing_country'],
                "billing_state" => $row['billing_state'],
                "billing_city" => $row['billing_city'],
                "billing_address" => $row['billing_street_namenumber'],
                "billing_zip_code" => trim($row['billing_zip_code'],'"'), // remove quotes from string
                "delivery_customer" => $row['delivery_customer'],
                "delivery_company_name" => $row['delivery_company_name'],
                "delivery_country" => $row['delivery_country'],
                "delivery_state" => $row['delivery_state'],
                "delivery_city" => $row['delivery_city'],
                "delivery_address" => $row['delivery_street_namenumber'],
                "delivery_zip_code" => $row['delivery_zip_code'],
                "buyer_phone" => trim($row['buyers_phone'],'"'), // remove quotes from string
                "shipping_label" => $row['shipping_label'],
                "buyer_email" => $row['buyers_email'],
                "delivery_method" => $row['delivery_method'],
                "item_name" => $row['items_name'],
                "item_variant" => $row['items_variant'],
                "sku" => $row['sku'],
                "quantity" => $row['qty'],
                "item_price" => $row['items_price'],
                "item_weight" => $row['items_weight'],
                "item_custom_text" => $row['items_custom_text'],
                "coupon" => $row['coupon'],
                "notes_to_seller" => $row['notes_to_seller'],
                "shipping" => $row['shipping'],
                "tax" => $row['tax'],
                // "gift_card" => $row['gift_card'],
                "total" => $row['total'],
                "currency" => $row['currency'],
                "payment_mentod" => $row['payment_method'],
                "payment" => $row['payment'],
                "fulfillment" => $row['fulfillment'],
                "refund" => $row['refund'],
                "total_after_refund" => $row['total_after_refund'],
                "quantity_refunded" => $row['qty_refunded'],
                "quatity_restocked" => $row['qty_restocked'],
                "additional_info" => $row['additional_info'],
                "user_id" => Auth::id(),
                "statuses_id" => $confirm_id,

            ]);            
        }
    }


    // Following will avoid to add deuplicate Order # in database
    public function rules(): array
    {
        return [
            '0' => Rule::unique(['orders', 'order_no'])
        ];
    }

    // Following will start adding records from second row of excel file. First row contains header row
    // public function startRow(): int
    // {
    //     return 2;
    // }    


    /////////////////////////////////////////////////////////////////////////    
    private function combineDateAndTime($dateReceived, $timeReceived) 
    {
        $date = new DateTime($dateReceived);
        $time = new DateTime($timeReceived);

        $merge = new DateTime($date->format('Y-m-d') .' ' .$time->format('H:i:s'));
        return $merge->format('Y-m-d H:i:s'); // Outputs '2017-03-14 13:37:42'

    }
}
