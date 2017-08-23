<?php

namespace AutowpTest\ZFComponents;

class HumanTimeTest extends \PHPUnit\Framework\TestCase
{
    private function getView()
    {
        $app = \Zend\Mvc\Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        return $serviceManager->get('ViewRenderer');
    }

    public function testHelperWorks()
    {
        $html = $this->getView()->humanTime(new \DateTime());

        $this->assertEquals('now', $html);
    }
}
