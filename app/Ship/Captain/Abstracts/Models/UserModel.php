<?php

namespace App\Ship\Captain\Abstracts\Models;

use App\Ship\Captain\Abstracts\Factories\HasFactory;
use Baethon\LaravelCriteria\Traits\AppliesCriteria;
use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class UserModel extends Authenticatable
{
    use HasFactory;
    use AppliesCriteria;
}
