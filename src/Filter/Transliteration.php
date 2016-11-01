<?php

namespace Autowp\ZFComponents\Filter;

use Zend\Filter\FilterInterface;

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
