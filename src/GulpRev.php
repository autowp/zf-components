<?php

namespace Autowp\ZFComponents;

use Zend\Json\Json;

class GulpRev
{
    private $manifestPath = null;
    
    private $manifest = null;
    
    private $prefix = null;
    
    public function __construct(array $options)
    {
        if (!isset($options['manifest'])) {
            throw new \Exception('`manifest` not provided');
        }
        
        $this->manifestPath = (string)$options['manifest'];
        
        if (!isset($options['prefix'])) {
            throw new \Exception('`prefix` not provided');
        }
        
        $this->prefix = (string)$options['prefix'];
    }
    
    private function loadManifest()
    {
        if ($this->manifest !== null) {
            return;
        }

        $this->manifest = [];
        
        if ($this->manifestPath && file_exists($this->manifestPath)) {
            $json = file_get_contents($this->manifestPath);
            
            $this->manifest = Json::decode($json, Json::TYPE_ARRAY);
        }
    }
    
    public function getRevUrl($file)
    {
        $this->loadManifest();
        
        if (isset($this->manifest[$file])) {
            return $this->prefix . $this->manifest[$file];
        } else {
            return $this->prefix . $file;
        }
    }
}