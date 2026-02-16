<?php

namespace App\Concerns;

use App\Services\Envelope\Facades\Envelope;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

trait ApiResponse
{
    private $statusCode = HttpResponse::HTTP_OK;

    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    protected function respond($data, $headers = [])
    {
        $envelope = Envelope::withData($data);

        return Response::json($envelope, $this->getStatusCode(), $headers);
    }

    protected function respondCreated($data, $headers = [])
    {
        $envelope = Envelope::withData($data);

        return $this->setStatusCode(HttpResponse::HTTP_CREATED)->respond($envelope, $headers);
    }

    /*
    protected function respondNoContent($data, $headers = [])
    {
        return $this->setStatusCode(HttpResponse::HTTP_NO_CONTENT)->respond($data, $headers);
    }
    */

    protected function respondWithError($message)
    {
        $status_code = $this->getStatusCode();

        /*
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $status_code
            ]
        ]);
        */
        return $this->respond(['error' => compact('message', 'status_code')]);
    }

    protected function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(HttpResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    protected function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(HttpResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    protected function wrap($str): string
    {
        return '('.$str.')';
    }
}
