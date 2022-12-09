<?php

namespace App\Ship\Captain\Abstracts\Responders;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

abstract class AbstractResponder
{
    public function __construct(
        private Request $request
    ) {
    }

    public function run($data = null)
    {
        if ($this->request->wantsJson()) {
            $json = $this->json($data);

            return response()->json($json, $json['status']);
        }

        return View::make(...$this->view($data));
    }

    abstract public function json(): array;

    abstract public function view($data): array;
}
