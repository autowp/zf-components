<?php

namespace AutowpTest\ZFComponents;

use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;

use Autowp\ZFComponents\Db\TableManager;

class DbTableManagerTest extends \PHPUnit\Framework\TestCase
{
    public function testGetTable()
    {
        $app = Application::init(require __DIR__ . '/_files/config/application.config.php');
        $serviceManager = $app->getServiceManager();
        $tables = $serviceManager->get('TableManager');

        $table = $tables->get('foo');

        $this->assertInstanceOf(TableGateway::class, $table);
    }
}
