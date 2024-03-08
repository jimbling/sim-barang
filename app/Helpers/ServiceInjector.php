<?php

namespace App\Helpers;

use App\Services\SettingsService;

class ServiceInjector
{
    protected static $settingsService;

    public static function getSettingsService()
    {
        if (!isset(self::$settingsService)) {
            self::$settingsService = new SettingsService();
        }

        return self::$settingsService;
    }
}
