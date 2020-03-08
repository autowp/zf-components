<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\Rollbar;

use Exception;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Rollbar\RollbarLogger;

class LoggerFactory implements FactoryInterface
{
    /**
     * @param string $requestedName
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws Exception
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): RollbarLogger
    {
        $config = $container->get('Config');

        if (! isset($config['rollbar']['logger'])) {
            throw new Exception("`config/rollbar/logger not provided");
        }

        return new RollbarLogger($config['rollbar']['logger']);
    }
}
