<?php

namespace AutowpTest\ZFComponents;

use Zend\Mail\Transport;
use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;

use Autowp\ZFComponents\Mail\Transport\TransportServiceFactory;

class MailTransportServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryWorks()
    {
        $app = Application::init(require __DIR__ . '/_files/config/application.config.php');
        $serviceManager = $app->getServiceManager();
        $transport = $serviceManager->get(Transport\TransportInterface::class);

        $this->assertInstanceOf(Transport\TransportInterface::class, $transport);
    }

    /**
     * @dataProvider configProvider
     */
    public function testTransportCreates($transportConfig, $expected)
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('config', [
            'mail' => [
                'transport' => $transportConfig
            ]
        ]);

        $serviceFactory = new TransportServiceFactory();

        $transport = $serviceFactory($serviceManager, Transport\TransportInterface::class);

        $this->assertInstanceOf($expected, $transport);
    }

    /**
     * @expectedException Exception
     */
    public function testExceptionThrowsOnMissingType()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('config', [
            'mail' => [
                'transport' => []
            ]
        ]);

        $serviceFactory = new TransportServiceFactory();

        $transport = $serviceFactory($serviceManager, Transport\TransportInterface::class);

        $this->assertInstanceOf($expected, $transport);
    }

    /**
     * @expectedException Exception
     */
    public function testExceptionThrowsOnInvalidType()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('config', [
            'mail' => [
                'transport' => [
                    'type' => 'invalid'
                ]
            ]
        ]);

        $serviceFactory = new TransportServiceFactory();

        $transport = $serviceFactory($serviceManager, Transport\TransportInterface::class);

        $this->assertInstanceOf($expected, $transport);
    }

    public static function configProvider()
    {
        return [
            [
                [
                    'type'    => 'file',
                    'options' => [
                        'path' => sys_get_temp_dir()
                    ],
                ],
                Transport\File::class
            ],
            [
                [
                    'type'    => 'in-memory',
                ],
                Transport\InMemory::class
            ],
            [
                [
                    'type'    => 'null',
                ],
                Transport\InMemory::class
            ],
            [
                [
                    'type'    => 'sendmail'
                ],
                Transport\Sendmail::class
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
                            'ssl'      => 'tls'
                        ],
                    ],
                ],
                Transport\Smtp::class
            ],
        ];
    }
}
