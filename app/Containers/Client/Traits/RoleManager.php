<?php

namespace App\Containers\Client\Traits;

use App\Containers\Client\Nova\Roles\Admin;
use App\Containers\Client\Nova\Roles\ContentManager;
use App\Containers\Client\Nova\Roles\Editor;

trait RoleManager
{
    public function getAdmin(): Admin
    {
        return new Admin();
    }

    public function getEditor(): Editor
    {
        return new Editor();
    }

    public function getContentManager(): ContentManager
    {
        return new ContentManager();
    }

    public static function admin(): Admin
    {
        return new Admin();
    }

    public static function editor(): Editor
    {
        return new Editor();
    }

    public static function contentManager(): ContentManager
    {
        return new ContentManager();
    }
}
