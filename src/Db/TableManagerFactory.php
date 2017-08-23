<?php

namespace Autowp\ZFComponents\Db;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TableManagerFactory implements FactoryInterface
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');

        return new TableManager(
            $container->get(\Zend\Db\Adapter\AdapterInterface::class),
            $config['tables']
        );
    }
}
