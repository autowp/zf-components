<?php

namespace Autowp\ZFComponents\View\Helper;

use Zend\View\Helper\AbstractHtmlElement;

class HtmlA extends AbstractHtmlElement
{
    /**
     * @param array|string $attribs
     * @param string $content
     * @param bool $escape
     * @return string
     */
    public function __invoke($attribs, $content, $escape = true)
    {
        if ($escape) {
            $content = $this->view->escapeHtml($content);
        }

        if (!is_array($attribs)) {
            $attribs = ['href' => $attribs];
        }

        if (isset($attribs['shuffle']) && $attribs['shuffle']) {
            unset($attribs['shuffle']);
            $attribs = $this->shuffleAttribs($attribs);
        }

        foreach ($attribs as $key => $value) {
            if (!isset($value)) {
                unset($attribs[$key]);
            }
        }

        return '<a' . $this->htmlAttribs($attribs) . '>' . $content . '</a>';
    }

    /**
     * @param array|string $attribs
     * @return string
     */
    public function url($attribs)
    {
        if (!is_array($attribs)) {
            $attribs = ['href' => $attribs];
        }

        $href = isset($attribs['href']) ? $attribs['href'] : '';

        $title = $href;
        if ($href) {
            $parsedUrl = parse_url($href);

            $title = (isset($parsedUrl['host']) ? $parsedUrl['host'] : '');
            $title = preg_replace('|^www\.|isu', '', $title);
        }

        return $this->htmlA($attribs, $title, true);
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
