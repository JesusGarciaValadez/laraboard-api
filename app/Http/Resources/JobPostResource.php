<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobPostResource extends JsonResource
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
            'countries' => $this->countries,
            'title' => $this->title,
            'description' => $this->description,
            'is_remote' => $this->is_remote,
            'url' => $this->url,
            'tags' => $this->tags,
            'logo_url' => $this->logo_url,
            'enhancements' => $this->enhancements,
            'go_live_date' => $this->go_live_date,
            'due_date' => $this->due_date,
            'is_active' => $this->is_active,
            'is_live' => $this->isLive,
            'order' => new OrderResource($this->order),
            'createdBy' => new UserResource($this->createdBy),
            'updatedBy' => new UserResource($this->updatedBy),
        ];
    }
}
