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
    
    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    
    public function __invoke(array $options = [])
    {
        $map = [
            'stylesheets' => 'addStylesheet',
            'scripts'     => 'addScript'
        ];
        
        foreach ($map as $key => $method) {
            if (isset($options[$key]) && is_array($options[$key])) {
                foreach ($options[$key] as $file) {
                    if (!is_array($file)) {
                        $file = [$file];
                    }
                    call_user_func_array([$this, $method], $file);
                }
            }
        }
        
        return $this;
    }

    public function addScript($file, $type = 'text/javascript', $attributes = [])
    {
        $url = $this->service->getRevUrl($file);
        
        $this->view->headScript()->appendFile($url, $type, $attributes);
    }
    
    public function addStylesheet($file, $media = 'screen')
    {
        $url = $this->service->getRevUrl($file);
    
        $this->view->headLink()->appendStylesheet($url, $media);
    }
}
