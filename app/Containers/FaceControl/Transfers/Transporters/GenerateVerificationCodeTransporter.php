<?php

namespace App\Containers\FaceControl\Transfers\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class GenerateVerificationCodeTransporter extends Transporter
{
    public string $phone;
}
