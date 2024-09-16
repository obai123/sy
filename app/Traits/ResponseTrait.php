<?php

namespace App\Traits;

trait ResponseTrait
{
    /**
     * Format the response structure.
     *
     * @param string $status
     * @param string $message
     * @param mixed $data
     * @return array
     */
    public function formatResponse(string $status, string $message, $data): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }
}
