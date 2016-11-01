<?php

namespace Autowp\ZFComponents\Filter;

use Zend\Filter\FilterInterface;

class SingleSpaces implements FilterInterface
{
    public function filter($value)
    {
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
