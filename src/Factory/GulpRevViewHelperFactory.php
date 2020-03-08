<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\Factory;

use Autowp\ZFComponents\GulpRev as Service;
use Autowp\ZFComponents\View\Helper\GulpRev as Helper;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class GulpRevViewHelperFactory implements FactoryInterface
{
    /**
     * @param  string $requestedName
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Helper
    {
        $service = $container->get(Service::class);

        return new Helper($service);
    }
}
