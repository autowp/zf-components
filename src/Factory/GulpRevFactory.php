<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\Factory;

use Autowp\ZFComponents\GulpRev;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class GulpRevFactory implements FactoryInterface
{
    /**
     * @param string $requestedName
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): GulpRev
    {
        $config    = $container->has('config') ? $container->get('config') : [];
        $revConfig = $config['gulp-rev'] ?? [];

        return new GulpRev($revConfig);
    }
}
