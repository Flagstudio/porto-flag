<?php

namespace App\Ship\Captain\Abstracts\Requests;

use App\Ship\Captain\Abstracts\Transporters\Transporter;
use App\Ship\Captain\Exceptions\MissingTransporterException;
use Illuminate\Foundation\Http\FormRequest as LaravelRequest;

abstract class Request extends LaravelRequest
{
    abstract public function transporter(): string;

    public function transported(): Transporter
    {
        if (! $this->transporter()) {
            throw new MissingTransporterException();
        }

        return $this->transporter()::fromRequest($this);
    }
}
