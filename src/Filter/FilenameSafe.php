<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\Filter;

use Laminas\Filter\FilterInterface;

use function mb_strtolower;
use function preg_replace;
use function str_replace;
use function strlen;
use function strtr;
use function trim;

class FilenameSafe implements FilterInterface
{
    private array $replaces = [
        "№"  => "N",
        " "  => '_',
        '"'  => '_',
        "/"  => '_',
        '*'  => '_',
        '`'  => '_',
        '#'  => '_',
        '&'  => '_',
        '\\' => '_',
        '!'  => '_',
        '@'  => '_',
        '$'  => 's',
        '%'  => '_',
        '^'  => '_',
        '='  => '-',
        '|'  => '_',
        '?'  => '_',
        '„'  => ',',
        '“'  => '_',
        '”'  => '_',
        '{'  => '(',
        '}'  => ')',
        ':'  => '-',
        ';'  => '_',
        '-'  => '-',
    ];

    /**
     * Defined by FilterInterface
     *
     * @param  mixed $value
     * @return string
     */
    public function filter($value)
    {
        $transliteration = new Transliteration();

        $value = $transliteration->filter($value);
        $value = mb_strtolower($value);

        $value = strtr($value, $this->replaces);

        $value = trim($value, '_-');

        $value = preg_replace('|[^A-Za-z0-9.(){}_-]|isu', '_', $value);

        do {
            $oldLength = strlen($value);
            $value     = str_replace('__', '_', $value);
        } while ($oldLength !== strlen($value));

        if (strlen($value) === 0) {
            $value = '_';
        }

        $map = [
            '..' => '__',
            '.'  => '_',
        ];

        if (isset($map[$value])) {
            $value = $map[$value];
        }

        return $value;
    }
}
