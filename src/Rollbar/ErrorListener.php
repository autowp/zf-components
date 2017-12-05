<?php

namespace Autowp\ZFComponents\Rollbar;

use Rollbar\RollbarLogger;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\Mvc\MvcEvent;

class ErrorListener extends AbstractListenerAggregate
{
    /**
     * @param EventManagerInterface $events
     * @param int                   $priority
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
            throw new \Exception('config/rollbar/debounce not provided');
        }

        $filePath = $config['rollbar']['debounce']['file'];
        $period = $config['rollbar']['debounce']['period'];

        if (file_exists($filePath)) {
            $mtime = filemtime($filePath);
            $diff = time() - $mtime;
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
