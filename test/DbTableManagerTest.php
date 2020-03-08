<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Mvc\Application;
use PHPUnit\Framework\TestCase;

class DbTableManagerTest extends TestCase
{
    public function testGetTable(): void
    {
        $app            = Application::init(require __DIR__ . '/_files/config/application.config.php');
        $serviceManager = $app->getServiceManager();
        $tables         = $serviceManager->get('TableManager');

        $table = $tables->get('foo');

        $this->assertInstanceOf(TableGateway::class, $table);
    }
}
