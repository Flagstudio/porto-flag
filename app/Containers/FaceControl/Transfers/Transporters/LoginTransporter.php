<?php

namespace App\Containers\FaceControl\Transfers\Transporters;

use App\Ship\Parents\Transporters\Transporter;
use Spatie\DataTransferObject\Attributes\MapFrom;

class LoginTransporter extends Transporter
{
    public string $phone;

    #[MapFrom('verify_code')]
    public string $verifyCode;
}
