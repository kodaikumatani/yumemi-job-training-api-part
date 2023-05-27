<?php

namespace App\Http\Resources;

use App\Models\Sales;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class YearlySalesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'month'    => $this->month,
            'value'    => $this->value,
            'stores'   => StoreResource::collection(Sales::fetchYearlySalesByStore($this->month)),
            'products' => ProductResource::collection(Sales::fetchYearlySalesByProduct($this->month)),
        ];
    }
}
