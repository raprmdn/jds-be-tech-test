<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ApiSuccessResponse implements Responsable
{
    public function __construct
    (
        protected string $message,
        protected mixed $data = null,
        protected int $code = ResponseAlias::HTTP_OK,
        protected array $headers = [],
    ){}

    public function toResponse($request): \Illuminate\Http\JsonResponse|ResponseAlias
    {
        $response = [
            'success' => true,
            'message' => $this->message,
        ];

        if ($this->data) {
            $response['data'] = $this->data;
        }

        return response()->json($response, $this->code, $this->headers);
    }
}
