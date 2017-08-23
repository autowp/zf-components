<?php

namespace Autowp\ZFComponents\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

use Autowp\ZFComponents\GulpRev;

class GulpRevFactory implements FactoryInterface
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->has('config') ? $container->get('config') : [];
        $revConfig = isset($config['gulp-rev']) ? $config['gulp-rev'] : [];

        return new GulpRev($revConfig);
    }
}
