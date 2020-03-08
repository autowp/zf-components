<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\Db;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class TableManagerFactory implements FactoryInterface
{
    /**
     * @param string $requestedName
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): TableManager
    {
        $config = $container->get('Config');

        return new TableManager(
            $container->get(AdapterInterface::class),
            $config['tables']
        );
    }
}
