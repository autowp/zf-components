<?php

namespace Autowp\ZFComponents\Rollbar;

use Interop\Container\ContainerInterface;
use Rollbar\RollbarLogger;
use Zend\ServiceManager\Factory\FactoryInterface;

class LoggerFactory implements FactoryInterface
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');

        if (! isset($config['rollbar']['logger'])) {
            throw new \Exception("`config/rollbar/logger not provided");
        }

        return new RollbarLogger($config['rollbar']['logger']);
    }
}
