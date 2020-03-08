<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use Autowp\ZFComponents\Mail\Transport\TransportServiceFactory;
use Exception;
use Laminas\Mail\Transport;
use Laminas\Mvc\Application;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;

use function sys_get_temp_dir;

class MailTransportServiceFactoryTest extends TestCase
{
    public function testFactoryWorks(): void
    {
        $app            = Application::init(require __DIR__ . '/_files/config/application.config.php');
        $serviceManager = $app->getServiceManager();
        $transport      = $serviceManager->get(Transport\TransportInterface::class);

        $this->assertInstanceOf(Transport\TransportInterface::class, $transport);
    }

    /**
     * @dataProvider configProvider
     * @throws Exception
     */
    public function testTransportCreates(array $transportConfig, string $expected): void
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('config', [
            'mail' => [
                'transport' => $transportConfig,
            ],
        ]);

        $serviceFactory = new TransportServiceFactory();

        $transport = $serviceFactory($serviceManager, Transport\TransportInterface::class);

        $this->assertInstanceOf($expected, $transport);
    }

    /**
     * @throws Exception
     */
    public function testExceptionThrowsOnMissingType(): void
    {
        $this->expectException(Exception::class);

        $serviceManager = new ServiceManager();
        $serviceManager->setService('config', [
            'mail' => [
                'transport' => [],
            ],
        ]);

        $serviceFactory = new TransportServiceFactory();

        $serviceFactory($serviceManager, Transport\TransportInterface::class);
    }

    /**
     * @throws Exception
     */
    public function testExceptionThrowsOnInvalidType(): void
    {
        $this->expectException(Exception::class);

        $serviceManager = new ServiceManager();
        $serviceManager->setService('config', [
            'mail' => [
                'transport' => [
                    'type' => 'invalid',
                ],
            ],
        ]);

        $serviceFactory = new TransportServiceFactory();

        $serviceFactory($serviceManager, Transport\TransportInterface::class);
    }

    public static function configProvider(): array
    {
        return [
            [
                [
                    'type'    => 'file',
                    'options' => [
                        'path' => sys_get_temp_dir(),
                    ],
                ],
                Transport\File::class,
            ],
            [
                [
                    'type' => 'in-memory',
                ],
                Transport\InMemory::class,
            ],
            [
                [
                    'type' => 'null',
                ],
                Transport\InMemory::class,
            ],
            [
                [
                    'type' => 'sendmail',
                ],
                Transport\Sendmail::class,
            ],
            [
                [
                    'type'    => 'smtp',
                    'options' => [
                        'host'              => 'smtp.example.com',
                        'connection_class'  => 'login',
                        'connection_config' => [
                            'username' => 'no-reply@example.com',
                            'password' => '',
                            'ssl'      => 'tls',
                        ],
                    ],
                ],
                Transport\Smtp::class,
            ],
        ];
    }
}
