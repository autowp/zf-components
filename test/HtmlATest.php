<?php

namespace AutowpTest\ZFComponents;

class HtmlATest extends \PHPUnit\Framework\TestCase
{
    private function getView()
    {
        $app = \Zend\Mvc\Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        return $serviceManager->get('ViewRenderer');
    }

    public function testHelperWorks()
    {
        $html = $this->getView()->htmlA('http://example.com', 'example.com');

        $this->assertContains('<a href="http&#x3A;&#x2F;&#x2F;example.com">example.com</a>', $html);
    }

    public function testUrlShorthandWorks()
    {
        $html = $this->getView()->htmlA()->url('http://example.com');

        $this->assertContains('<a href="http&#x3A;&#x2F;&#x2F;example.com">example.com</a>', $html);
    }

    public function testShuffleAttributeUnsets()
    {
        $html = $this->getView()->htmlA([
            'href'    => 'http://example.com',
            'shuffle' => true
        ], 'example.com');

        $this->assertNotContains('shuffle', $html);
    }
}
