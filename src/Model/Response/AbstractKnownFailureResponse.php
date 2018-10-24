<?php

namespace App\Model\Response;

abstract class AbstractKnownFailureResponse extends AbstractFailureResponse
{
    /**
     * @var int
     */
    private $statusCode;

    public function __construct(string $requestHash, int $statusCode, string $type)
    {
        parent::__construct($requestHash, $type);

        $this->statusCode = $statusCode;
    }

    public function toScalarArray(): array
    {
        return array_merge(parent::toScalarArray(), [
            'status_code' => $this->statusCode,
        ]);
    }
}