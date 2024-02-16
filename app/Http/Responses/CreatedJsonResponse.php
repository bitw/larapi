<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

final class CreatedJsonResponse extends JsonResponse
{
    public function __construct(?array $data = null)
    {
        parent::__construct($data, self::HTTP_CREATED);
    }
}
