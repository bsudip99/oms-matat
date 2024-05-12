<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    /**
     * @var array<string, string|int|null>
     */
    private array $pagination;

    /**
     * @param  mixed  $resource
     */
    public function __construct(mixed $resource)
    {
        $this->pagination = $this->paginate($resource);
        $resource = $resource->getCollection();
        parent::__construct($resource);
    }

    /**
     * @param $request
     * @return array<string, string|int|null>
     */
    public function toArray($request): array
    {
        return $this->pagination;
    }

    /**
     * @param  mixed  $resource
     * @return array<string, string|int|null>
     */
    public function paginate(mixed $resource): array
    {
        return [
            'total' => $resource->total(),
            'count' => $resource->count(),
            'per_page' => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'next_page' => $resource->nextPageUrl() ?  $resource->currentPage() + 1 :  null,
            'last_page' => $resource->lastPage(),
            'from' => $resource->firstItem(),
            'to' => $resource->lastItem(),
            'first_page_url' => $resource->url(1),
            'next_page_url' => $resource->nextPageUrl(),
            'prev_page_url' => $resource->previousPageUrl(),
            'last_page_url' => $resource->url($resource->lastPage()),
        ];
    }
}
