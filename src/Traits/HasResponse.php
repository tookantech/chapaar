<?php

namespace Aryala7\Chapaar\Traits;

trait HasResponse
{
    public function generateResponse(int $status, string $message ,$data = NULL): object
    {
        return (object)[
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }
}
