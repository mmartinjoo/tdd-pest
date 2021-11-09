<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductPriceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'fromDate' => $this->from_date,
            'toDate' => $this->to_date,
            'price' => $this->price,
        ];
    }
}
