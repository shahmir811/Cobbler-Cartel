<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogsResource extends JsonResource
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
            'description' => $this->description,
            'type' => $this->type,
            'amount' => number_format($this->amount, 2),
            'user' => $this->user->name,
            'created_at' => date("d M Y h:i A", strtotime($this->created_at)),
        ];
    }
}
