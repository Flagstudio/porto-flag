<?php

namespace App\Containers\FaceControl\Http\Requests;

use App\Containers\FaceControl\Transfers\Transporters\LoginTransporter;
use App\Ship\Parents\Requests\Request;
use App\Ship\Rules\PhoneRule;

class LoginRequest extends Request
{
    public function transporter(): string
    {
        return LoginTransporter::class;
    }

    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                'numeric',
                new PhoneRule(),
                'exists:users,phone',
            ],
            'verify_code' => 'required|digits:4',
        ];
    }
}
