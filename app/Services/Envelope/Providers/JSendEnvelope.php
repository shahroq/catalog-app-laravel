<?php

namespace App\Services\Envelope\Providers;

use App\Services\Envelope\Contracts\Envelope;
use Illuminate\Support\Facades\Config;
use League\Config\Exception\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class JSendEnvelope implements Envelope
{
    protected $config;

    private mixed $error = null;

    private mixed $data = null;

    public function __construct()
    {
        $this->config = Config::get('envelope.drivers.jsend');
    }

    public function withData(mixed $data = null): static
    {
        $this->data = $data;

        return $this;
    }

    public function withError(mixed $error = null): static
    {
        $this->error = $error;

        return $this;
    }

    public function toArray(): array
    {
        $status = $this->getStatus();

        return match ($status) {
            'success' => $this->formatSuccess(),
            'fail' => $this->formatFail(),
            'error' => $this->formatError(),
        };

    }

    private function getStatus(): string
    {
        if (! $this->error) {
            return 'success';
        }

        if ($this->isAppError($this->error)) {
            return 'fail';
        }

        return 'error';
    }

    private function formatSuccess(): array
    {
        return [
            'status' => 'success',
            'data' => $this->data,
        ];
    }

    private function formatFail(): array
    {
        return [
            'status' => 'fail',
            'data' => array_filter([
                'message' => $this->getMessage(),
                'status_code' => $this->getStatusCode(),
                'code' => $this->error?->getCode() ?? null,
                'details' => method_exists($this->error, 'errors') ? $this->error->errors() : null,
            ], fn ($value) => ! is_null($value)),
        ];
    }

    private function formatError(): array
    {
        return array_filter([
            'status' => 'error',
            'message' => $this->getMessage(),
            'code' => $this->error?->code ?? null,
        ], fn ($value) => ! is_null($value));
    }

    private function isAppError(): bool
    {
        // dd(get_class($this->error));

        // check by exception or statusCode?

        if (
            $this->error instanceof ValidationException ||
            $this->error instanceof HttpExceptionInterface
        ) {
            return true;
        }

        if (
            str_starts_with(get_class($this->error), 'App') ||
            str_starts_with(get_class($this->error), 'Illuminate')
        ) {
            return true;
        }

        $statusCode = $this->getStatusCode();
        if ($statusCode >= 400 && $statusCode < 500) {
            return true;
        }

        return false;
    }

    private function getMessage(): string
    {
        $message = $this->error instanceof \Throwable
            ? $this->error->getMessage()
            : 'Internal Error..';

        return $message;
    }

    private function getStatusCode(): int
    {
        $statusCode = 500;

        if (property_exists($this->error, 'status')) {
            $statusCode = $this->error->status;
        }
        if (method_exists($this->error, 'getStatusCode')) {
            $statusCode = $this->error->getStatusCode();
        }

        return $statusCode;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
