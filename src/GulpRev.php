<?php

namespace Autowp\ZFComponents;

use Zend\Json\Json;

class GulpRev
{
    /**
     * @var array
     */
    private $manifests = [];

    public function __construct(array $options)
    {
        $manifests = [];
        if (isset($options['manifests']) && is_array($options['manifests'])) {
            $manifests = $options['manifests'];
        }

        if (isset($options['manifest'])) {
            $manifests['default'] = [
                'manifest' => $options['manifest'],
                'prefix'   => $options['prefix']
            ];
        }

        foreach ($manifests as $manifest) {
            if (! isset($manifest['manifest'])) {
                throw new \Exception('`manifest` not provided');
            }
            if (! isset($manifest['prefix'])) {
                throw new \Exception('`prefix` not provided');
            }
        }

        $this->manifests = $manifests;
    }

    private function loadManifest($manifestName)
    {
        if (! isset($this->manifests[$manifestName])) {
            throw new \Exception('Manifest`{$manifestName}` not found');
        }

        $manifest = $this->manifests[$manifestName];

        if (isset($manifest['content'])) {
            return $manifest['content'];
        }

        if (! $manifest['manifest'] || ! file_exists($manifest['manifest'])) {
            return null;
        }

        $json = file_get_contents($manifest['manifest']);

        $content = Json::decode($json, Json::TYPE_ARRAY);

        $this->manifests[$manifestName]['content'] = $content;

        return $content;
    }

    public function getRevUrl($file, $manifestName = 'default')
    {
        $content = $this->loadManifest($manifestName);

        $prefix = $this->manifests[$manifestName]['prefix'];

        if ($content && isset($content[$file])) {
            return $prefix . $content[$file];
        } else {
            return $prefix . $file;
        }
    }
}
