<?php

namespace Autowp\ZFComponents\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Autowp\ZFComponents\GulpRev as Service;

class GulpRev extends AbstractHelper
{
    /**
     * @var Service
     */
    private $service;

    /**
     * @param Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * @param array $options
     * @return GulpRev
     */
    public function __invoke(array $options = [], $manifest = 'default')
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
     * @param string $file
     * @param string $type
     * @param array $attributes
     * @return GulpRev
     */
    public function addScript($file, $type = 'text/javascript', array $attributes = [], $manifest = 'default')
    {
        $url = $this->service->getRevUrl($file, $manifest);

        $this->view->headScript()->appendFile($url, $type, $attributes);

        return $this;
    }

    /**
     * @param string $file
     * @param string $media
     * @return GulpRev
     */
    public function addStylesheet($file, $media = 'screen', $manifest = 'default')
    {
        $url = $this->service->getRevUrl($file, $manifest);

        $this->view->headLink()->appendStylesheet($url, $media);

        return $this;
    }

    public function script($file, $manifest = 'default')
    {
        $url = $this->service->getRevUrl($file, $manifest);

        return '<script type="text/javascript" src="'.$this->view->escapeHtmlAttr($url).'"></script>';
    }
}
