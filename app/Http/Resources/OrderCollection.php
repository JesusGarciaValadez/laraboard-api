<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $links = $this->linkCollection();
        return [
            'data' => $this->collection,
            'links' => [
                'first' => $links->get(1)['url'],
                'last' => $links->get($links->count() - 2)['url'],
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'last_page' => $this->lastItem(),
                'path' => $this->path(),
                'per_page' => $this->perPage(),
                'to' => $this->count(),
                'total' => $this->total(),
            ],
        ];
    }
}
