<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\View\Helper;

use Laminas\View\Helper\AbstractHtmlElement;

use function array_flip;
use function array_keys;
use function array_merge;
use function is_array;
use function parse_url;
use function preg_replace;
use function shuffle;

class HtmlA extends AbstractHtmlElement
{
    /**
     * @param array|string $attribs
     * @param string       $content
     * @param bool         $escape
     * @return string
     */
    public function __invoke($attribs = [], $content = '', $escape = true)
    {
        if (! $content && ! $attribs) {
            return $this;
        }

        if ($escape) {
            $content = $this->view->escapeHtml($content);
        }

        if (! is_array($attribs)) {
            $attribs = ['href' => $attribs];
        }

        if (isset($attribs['shuffle']) && $attribs['shuffle']) {
            unset($attribs['shuffle']);
            $attribs = $this->shuffleAttribs($attribs);
        }

        foreach ($attribs as $key => $value) {
            if (! isset($value)) {
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
        if (! is_array($attribs)) {
            $attribs = ['href' => $attribs];
        }

        $href = $attribs['href'] ?? '';

        $title = $href;
        if ($href) {
            $parsedUrl = parse_url($href);

            $title = $parsedUrl['host'] ?? '';
            $title = preg_replace('|^www\.|isu', '', $title);
        }

        return $this->__invoke($attribs, $title, true);
    }

    /**
     * @return array
     */
    private function shuffleAttribs(array $attribs)
    {
        $keys = array_keys($attribs);
        shuffle($keys);
        return array_merge(array_flip($keys), $attribs);
    }
}
