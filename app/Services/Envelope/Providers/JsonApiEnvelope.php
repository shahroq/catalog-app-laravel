<?php

namespace App\Services\Envelope\Providers;

use App\Services\Envelope\Contracts\Envelope;
use Illuminate\Support\Facades\Config;

class JsonApiEnvelope implements Envelope
{
    protected $config;

    private mixed $error = null;

    private mixed $data = null;

    public function __construct()
    {
        $this->config = Config::get('envelope.drivers.jsonapi');
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
        if ($this->error) {
            return $this->formatError();
        }

        return $this->formatSuccess();
    }

    public function formatSuccess(): array
    {
        return [
            'jsonapi' => ['version' => $this->config['version']],
            'data' => $this->data,
        ];
    }

    public function formatError(): array
    {
        $message = $this->error?->getMessage();

        return [
            'jsonapi' => ['version' => $this->config['version']],
            'errors' => [
                ['title' => $message, 'detail' => $this->data],
            ],
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
