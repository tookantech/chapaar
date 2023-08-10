<?php

namespace Aryala7\Chapaar\Traits;

trait HasResponse
{
    public function generateResponse(int $status, string $message, $data = null): object
    {
        return (object) [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }
}
