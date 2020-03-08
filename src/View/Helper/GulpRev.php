<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\View\Helper;

use Autowp\ZFComponents\GulpRev as Service;
use Laminas\View\Helper\AbstractHelper;

use function is_array;

class GulpRev extends AbstractHelper
{
    /** @var Service */
    private Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @return $this
     */
    public function __invoke(array $options = [], string $manifest = 'default'): self
    {
        if (isset($options['stylesheets']) && is_array($options['stylesheets'])) {
            foreach ($options['stylesheets'] as $file) {
                $this->addStylesheet($file, 'screen', $manifest);
            }
        }

        if (isset($options['scripts']) && is_array($options['scripts'])) {
            foreach ($options['scripts'] as $file) {
                $this->addScript($file, 'text/javascript', [], $manifest);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function addScript(
        string $file,
        string $type = 'text/javascript',
        array $attributes = [],
        string $manifest = 'default'
    ): self {
        $url = $this->service->getRevUrl($file, $manifest);

        $this->view->headScript()->appendFile($url, $type, $attributes);

        return $this;
    }

    /**
     * @param string $file
     * @return $this
     */
    public function addStylesheet($file, string $media = 'screen', string $manifest = 'default'): self
    {
        $url = $this->service->getRevUrl($file, $manifest);

        $this->view->headLink()->appendStylesheet($url, $media);

        return $this;
    }

    public function script(string $file, string $manifest = 'default'): string
    {
        $url = $this->service->getRevUrl($file, $manifest);

        return '<script type="text/javascript" src="' . $this->view->escapeHtmlAttr($url) . '"></script>';
    }
}
