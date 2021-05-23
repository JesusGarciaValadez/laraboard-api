<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'catalog_code' => $this->catalog_code,
            'short_code' => $this->short_code,
            'amount' => $this->amount,
            'percentage' => $this->percentage,
            'is_unique' => $this->is_unique,
            'is_manual' => $this->is_manual,
            'is_redeemed' => $this->is_redeemed,
            'invoices' => new InvoiceCollection($this->whenLoaded('invoices')),
            'createdBy' => new UserResource($this->whenLoaded('createdBy')),
            'updatedBy' => new UserResource($this->whenLoaded('updatedBy')),
        ];
    }
}
