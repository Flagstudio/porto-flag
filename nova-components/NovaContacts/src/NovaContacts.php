<?php

namespace Flagstudio\NovaContacts;

use Laravel\Nova\Card;

class NovaContacts extends Card
{
    public function __construct($component = null)
    {
        parent::__construct($component);

        $this->withMeta([
            'flagstudioInfo' => [
                'testapp' => config('nova-contacts.test_url'),
                'login' => config('nova-contacts.basic_auth_login'),
                'password' => config('nova-contacts.basic_auth_password'),
            ],
        ]);
    }

    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'nova-contacts';
    }
}
