<?php

namespace App\Containers\Settings\Domain\Models;

use App\Ship\Captain\Abstracts\Factories\HasFactory;
use App\Ship\Parents\Models\Model;

class Settings extends Model
{
    use HasFactory;

    public const METRICS_SLUG = 'metrics';
    public const ROBOTS_SLUG = 'robots';

    protected $casts = [
        'fields' => 'array',
    ];
}
