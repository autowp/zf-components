<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\Filter;

use Laminas\Filter\FilterInterface;

use function explode;
use function implode;
use function preg_replace;
use function str_replace;
use function strlen;

class SingleSpaces implements FilterInterface
{
    /**
     * @param mixed $value
     */
    public function filter($value): string
    {
        $value = (string) $value;

        if (strlen($value) <= 0) {
            return '';
        }

        $value = str_replace("\r", "", $value);
        $lines = explode("\n", $value);
        foreach ($lines as &$line) {
            $line = preg_replace('/[[:space:]]+/s', ' ', $line);
        }
        return implode("\n", $lines);
    }
}
