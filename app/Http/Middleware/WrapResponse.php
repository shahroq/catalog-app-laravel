<?php

namespace App\Http\Middleware;

use App\Services\Envelope\Facades\Envelope;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WrapResponse
{
    /**
     * Wrap response in specified format
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only modify JSON responses
        if ($response instanceof \Illuminate\Http\JsonResponse) {

            // $isError = $response->exception || $response->getStatusCode() >= 400;
            $isError = false; // errors are handled in app.php

            $envelope = $isError ?
                Envelope::withError($response->exception) :
                Envelope::withData($response->getData(true));

            $response->setData($envelope);
        }

        return $response;

    }
}
