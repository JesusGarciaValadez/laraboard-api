<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'role' => new RoleResource($this->whenLoaded('role')),
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'metadata' => $this->metadata,
            'jobPosts' => new JobPostCollection($this->whenLoaded('jobPosts')),
            'orders' => new OrderCollection($this->whenLoaded('orders')),
            'invoices' => new InvoiceCollection($this->whenLoaded('invoices')),
        ];
    }
}
