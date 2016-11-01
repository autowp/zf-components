<?php

namespace Autowp\ZFComponents\Filter;

use Zend\Filter\FilterInterface;
use Autowp\ZFComponents\Filter\Transliteration;

class FilenameSafe implements FilterInterface
{
    private $replaces = [
        "№" => "N",
        " " => '_',
        '"' => '_',
        "/" => '_',
        '*' => '_',
        '`' => '_',
        '#' => '_',
        '&' => '_',
        '\\' => '_',
        '!' => '_',
        '@' => '_',
        '$' => 's',
        '%' => '_',
        '^' => '_',
        '=' => '-',
        '|' => '_',
        '?' => '_',
        '„' => ',',
        '“' => '_',
        '”' => '_',
        '{' => '(',
        '}' => ')',
        ':' => '-',
        ';' => '_',
        '-' => '-',
    ];

    /**
     * Defined by FilterInterface
     *
     * @param  string $value
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
            $value = str_replace('__', '_', $value);
        } while ($oldLength != strlen($value));

        if (strlen($value) == 0) {
            $value = '_';
        }

        switch ($value) {
            case '..': 
                $value = '__'; 
                break;
            case '.':  
                $value = '_'; 
                break;
        }

        return $value;
    }
}
