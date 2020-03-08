<?php

declare(strict_types=1);

namespace Autowp\ZFComponents;

use Laminas\Json\Json;

use function file_exists;
use function file_get_contents;
use function is_array;

class GulpRev
{
    /** @var array */
    private array $manifests = [];

    public function __construct(array $options)
    {
        $manifests = [];
        if (isset($options['manifests']) && is_array($options['manifests'])) {
            $manifests = $options['manifests'];
        }

        if (isset($options['manifest'])) {
            $manifests['default'] = [
                'manifest' => $options['manifest'],
                'prefix'   => $options['prefix'],
            ];
        }

        foreach ($manifests as $manifest) {
            if (! isset($manifest['manifest'])) {
                throw new GulpRevException('`manifest` not provided');
            }
            if (! isset($manifest['prefix'])) {
                throw new GulpRevException('`prefix` not provided');
            }
        }

        $this->manifests = $manifests;
    }

    /**
     * @throws GulpRevException
     */
    private function loadManifest(string $manifestName): ?array
    {
        if (! isset($this->manifests[$manifestName])) {
            throw new GulpRevException('Manifest`{$manifestName}` not found');
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

    public function getRevUrl(string $file, string $manifestName = 'default'): string
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
