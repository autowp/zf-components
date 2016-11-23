<?php

namespace Autowp\ZFComponents\View\Helper;

use Zend\View\Helper\AbstractHtmlElement;

class HtmlImg extends AbstractHtmlElement
{
    /**
     * @param array|string $attribs
     * @return string
     */
    public function __invoke($attribs)
    {
        if (! is_array($attribs)) {
            $attribs = ['src' => $attribs];
        }

        if (! isset($attribs['alt'])) {
            $attribs['alt'] = '';
        }

        if (isset($attribs['shuffle']) && $attribs['shuffle']) {
            unset($attribs['shuffle']);
            $attribs = $this->shuffleAttribs($attribs);
        }

        return '<img' . $this->htmlAttribs($attribs) . $this->getClosingBracket();
    }

    /**
     * @param array $attribs
     * @return array
     */
    private function shuffleAttribs(array $attribs)
    {
        $keys = array_keys($attribs);
        shuffle($keys);
        return array_merge(array_flip($keys), $attribs);
    }
}
