<?php

namespace App\Tests\Unit\Model\Response;

use App\Model\Response\SuccessResponse;

class SuccessResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider jsonSerializeDataProvider
     *
     * @param string $requestHash
     * @param string $expectedJson
     */
    public function testJsonSerialize(string $requestHash, string $expectedJson)
    {
        $response = new SuccessResponse($requestHash);

        $this->assertEquals($expectedJson, json_encode($response));
    }

    public function jsonSerializeDataProvider(): array
    {
        return [
            'empty headers, empty content' => [
                'requestHash' => 'request_hash_1',
                'expectedJson' => json_encode([
                    'request_id' => 'request_hash_1',
                    'status' => SuccessResponse::STATUS_SUCCESS,
                ]),
            ],
            'has headers, has content' => [
                'requestHash' => 'request_hash_2',
                'expectedJson' => json_encode([
                    'request_id' => 'request_hash_2',
                    'status' => SuccessResponse::STATUS_SUCCESS,
                ]),
            ],
        ];
    }
}
