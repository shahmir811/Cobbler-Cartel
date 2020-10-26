<?php

namespace App\Imports;

use Auth;
use DateTime;
use Carbon\Carbon;
use App\Models\{Order, Status};
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OrdersImport implements ToModel, WithStartRow
{

    public function model(array $row)
    {

        $confirm_id = Status::where('name', '=', 'confirmed')->pluck('id')->first();

        // We will first check whether the coming Order # is already imported to database or not.
        // if not we will dump the record in database

        if(!Order::where('order_no', '=', $row[0])->exists()) {

            return new Order([

                "order_no" => $row[0],
                "order_date" => $row[1],
                "order_time" => date("H:i:s", strtotime($row[2])),
                "order_received_at" => $this->combineDateAndTime($row[1], $row[2]),
                "billing_customer" => $row[3],
                "billing_company_name" => $row[4],
                "billing_country" => $row[5],
                "billing_state" => $row[6],
                "billing_city" => $row[7],
                "billing_address" => $row[8],
                "billing_zip_code" => trim($row[9],'"'), // remove quotes from string
                "delivery_customer" => $row[10],
                "delivery_company_name" => $row[11],
                "delivery_country" => $row[12],
                "delivery_state" => $row[13],
                "delivery_city" => $row[14],
                "delivery_address" => $row[15],
                "delivery_zip_code" => $row[16],
                "buyer_phone" => trim($row[17],'"'), // remove quotes from string
                "shipping_label" => $row[18],
                "buyer_email" => $row[19],
                "delivery_method" => $row[20],
                "item_name" => $row[21],
                "item_variant" => $row[22],
                "sku" => $row[23],
                "quantity" => $row[24],
                "item_price" => $row[25],
                "item_weight" => $row[26],
                "item_custom_text" => $row[27],
                "coupon" => $row[28],
                "notes_to_seller" => $row[29],
                "shipping" => $row[30],
                "tax" => $row[31],
                "gift_card" => $row[32],
                "total" => $row[33],
                "currency" => $row[34],
                "payment_mentod" => $row[35],
                "payment" => $row[36],
                "fulfillment" => $row[37],
                "refund" => $row[38],
                "total_after_refund" => $row[39],
                "quantity_refunded" => $row[40],
                "quatity_restocked" => $row[41],
                "additional_info" => $row[42],
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
    public function startRow(): int
    {
        return 2;
    }    


    /////////////////////////////////////////////////////////////////////////    
    private function combineDateAndTime($dateReceived, $timeReceived) 
    {
        $date = new DateTime($dateReceived);
        $time = new DateTime($timeReceived);

        $merge = new DateTime($date->format('Y-m-d') .' ' .$time->format('H:i:s'));
        return $merge->format('Y-m-d H:i:s'); // Outputs '2017-03-14 13:37:42'

    }
}
