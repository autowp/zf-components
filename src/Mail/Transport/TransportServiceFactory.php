<?php

namespace Autowp\ZFComponents\Mail\Transport;

use Interop\Container\ContainerInterface;

use Zend\Mail;
use Zend\ServiceManager\Factory\FactoryInterface;

class TransportServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->has('config') ? $container->get('config') : [];
        $mailConfig = isset($config['mail']) ? $config['mail'] : [];

        $transportConfig = isset($mailConfig['transport']) ? $mailConfig['transport'] : [];

        if (! isset($transportConfig['type'])) {
            throw new \Exception("Mail transport `type` not provided");
        }

        $transport = null;

        switch ($transportConfig['type']) {
            case 'null':
            case 'in-memory':
                $transport = new Mail\Transport\InMemory();
                break;

            case 'sendmail':
                $transport = new Mail\Transport\Sendmail();
                break;

            case 'smtp':
                $transport = new Mail\Transport\Smtp();
                if (isset($transportConfig['options'])) {
                    $transportOptions = new Mail\Transport\SmtpOptions($transportConfig['options']);
                    $transport->setOptions($transportOptions);
                }
                break;

            case 'file':
                $transport = new Mail\Transport\File();
                if (isset($transportConfig['options'])) {
                    $transportOptions = new Mail\Transport\FileOptions($transportConfig['options']);
                    $transport->setOptions($transportOptions);
                }
                break;

            default:
                throw new \Exception("Unexpected transport type `{$transportConfig['type']}`");
        }

        return $transport;
    }
}
