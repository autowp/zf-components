<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\Mail\Transport;

use Exception;
use Interop\Container\ContainerInterface;
use Laminas\Mail;
use Laminas\Mail\Transport\TransportInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class TransportServiceFactory implements FactoryInterface
{
    /**
     * @param  string $requestedName
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws Exception
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): TransportInterface
    {
        $config     = $container->has('config') ? $container->get('config') : [];
        $mailConfig = $config['mail'] ?? [];

        $transportConfig = $mailConfig['transport'] ?? [];

        if (! isset($transportConfig['type'])) {
            throw new Exception("Mail transport `type` not provided");
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
                throw new Exception("Unexpected transport type `{$transportConfig['type']}`");
        }

        return $transport;
    }
}
