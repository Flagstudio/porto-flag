<?php

namespace App\Containers\FaceControl\Http\Requests;

use App\Containers\FaceControl\Transfers\Transporters\GenerateVerificationCodeTransporter;
use App\Ship\Parents\Requests\Request;
use App\Ship\Rules\PhoneRule;

class GenerateVerificationCodeRequest extends Request
{
    public function transporter(): string
    {
        return GenerateVerificationCodeTransporter::class;
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
        ];
    }
}
