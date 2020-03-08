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
     *
     * @return string
     */
    public static function getBasePath()
    {
        return __DIR__ . '/../languages/';
    }

    /**
     * @return string
     */
    public static function getPatternForViewHelpers()
    {
        return '%s.php';
    }
}
