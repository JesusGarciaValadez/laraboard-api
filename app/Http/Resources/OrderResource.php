<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'jobPost' => new JobPostResource($this->whenLoaded('jobPost')),
            'discount' => new DiscountResource($this->whenLoaded('discount')),
            'created_by' => new UserResource($this->whenLoaded('createdBy')),
            'updated_by' => new UserResource($this->whenLoaded('updatedBy')),
            'status' => new OrderStatusResource($this->whenLoaded('status')),
            'billing_information' => $this->billing_information,
            'amount' => $this->amount,
            'tax_percentage' => $this->tax_percentage,
        ];
    }
}
