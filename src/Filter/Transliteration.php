<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\Filter;

use Laminas\Filter\FilterInterface;
use Transliterator;

class Transliteration implements FilterInterface
{
    /**
     * Defined by FilterInterface
     *
     * Returns $value translitered to ASCII
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        $tr = Transliterator::create('Any-Latin;Latin-ASCII;');
        return $tr->transliterate($value);
    }
}
