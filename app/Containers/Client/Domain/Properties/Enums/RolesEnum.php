<?php

namespace App\Containers\Client\Domain\Properties\Enums;

enum RolesEnum: string
{
    case CLIENT = 'client';
    case EDITOR = 'editor';
    case ADMIN = 'admin';
}
