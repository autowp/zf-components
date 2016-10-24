<?php

namespace Autowp\ZFComponents\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

use Autowp\ZFComponents\GulpRev as Service;
use Autowp\ZFComponents\View\Helper\GulpRev as Helper;

class GulpRevViewHelperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = $container->get(Service::class);

        return new Helper($service);
    }
}
