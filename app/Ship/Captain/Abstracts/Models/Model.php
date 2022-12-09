<?php

namespace App\Ship\Captain\Abstracts\Models;

use App\Ship\Captain\Abstracts\Factories\HasFactory;
use Baethon\LaravelCriteria\Traits\AppliesCriteria;
use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    use HasFactory;
    use AppliesCriteria;
}
