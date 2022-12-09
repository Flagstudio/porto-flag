<?php

namespace App\Containers\Settings\Transfers\Transporters;

use App\Containers\Settings\Domain\Models\Settings;
use App\Ship\Parents\Transporters\Transporter;

class SettingsVersionsTransporter extends Transporter
{
    public array $android;

    public array $ios;

    public bool $is_checking;

    public bool $is_blocking;

    public static function fromSettings(Settings $settings): static
    {
        return new static(
            android: $settings->fields['android'],
            ios: $settings->fields['ios'],
            is_checking: $settings->fields['is_checking'] ?? false,
            is_blocking: $settings->fields['is_blocking'] ?? false,
        );
    }
}
