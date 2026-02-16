<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveNullsFromResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only modify JSON responses
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $data = $response->getData(true);
            $cleaned = $this->removeNulls($data);

            $response->setData($cleaned);
        }

        return $response;
    }

    private function removeNulls(array $data): array
    {
        return array_filter(
            array_map(function ($value) {
                if (is_array($value)) {
                    return $this->removeNulls($value);
                }

                return $value;
            }, $data),
            fn ($value) => ! is_null($value)
        );
    }
}
