<?php

namespace App\Services\Envelope\Contracts;

use JsonSerializable;

interface Envelope extends JsonSerializable
{
    public function withData(mixed $data = null): static;

    public function withError(mixed $error = null): static;

    public function toArray(): array;
}
