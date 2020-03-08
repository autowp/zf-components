<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\Rollbar;

use Exception;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use Rollbar\RollbarLogger;

use function file_exists;
use function filemtime;
use function time;
use function touch;

class ErrorListener extends AbstractListenerAggregate
{
    /**
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'handleError'], $priority);
        $events->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'handleError'], $priority);
    }

    public function handleError(MvcEvent $e)
    {
        $exception = $e->getParam('exception');
        if (! $exception) {
            return;
        }

        $serviceManager = $e->getApplication()->getServiceManager();

        $config = $serviceManager->get('Config');
        if (! isset($config['rollbar']['debounce'])) {
            throw new Exception('config/rollbar/debounce not provided');
        }

        $filePath = $config['rollbar']['debounce']['file'];
        $period   = $config['rollbar']['debounce']['period'];

        if (file_exists($filePath)) {
            $mtime = filemtime($filePath);
            $diff  = time() - $mtime;
        } else {
            $diff = $period + 1;
        }

        if ($diff < $period) {
            return;
        }

        touch($filePath);

        /**
         * @var RollbarLogger $logger
         */
        $logger = $serviceManager->get(RollbarLogger::class);
        $logger->error($exception);
    }
}
