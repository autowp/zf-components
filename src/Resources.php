<?php

declare(strict_types=1);

namespace Autowp\ZFComponents;

final class Resources
{
    /**
     * Non-instantiable.
     */
    private function __construct()
    {
    }

    /**
     * Return the base path to the language resources.
     */
    public static function getBasePath(): string
    {
        return __DIR__ . '/../languages/';
    }

    public static function getPatternForViewHelpers(): string
    {
        return '%s.php';
    }
}
