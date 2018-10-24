<?php

namespace App\Model\Response;

use App\Entity\CachedResource;

class DecoratedSuccessResponse implements \JsonSerializable
{
    /**
     * @var SuccessResponse
     */
    private $response;

    /**
     * @var CachedResource
     */
    private $resource;

    public function __construct(SuccessResponse $response, CachedResource $resource)
    {
        $this->response = $response;
        $this->resource = $resource;
    }

    public function jsonSerialize(): array
    {
        return array_merge($this->response->jsonSerialize(), [
            'headers' => $this->resource->getHeaders()->toArray(),
            'content' => $this->resource->getBody(),
        ]);
    }
}
