<?php

namespace AutowpTest\ZFComponents;

class HumanDateTest extends \PHPUnit_Framework_TestCase
{
    private function getView()
    {
        $app = \Zend\Mvc\Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        return $serviceManager->get('ViewRenderer');
    }

    public function testHelperWorks()
    {
        $html = $this->getView()->humanDate(new \DateTime());

        $this->assertEquals('today', $html);
    }
}
