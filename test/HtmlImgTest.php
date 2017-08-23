<?php

namespace AutowpTest\ZFComponents;

class HtmlImgTest extends \PHPUnit\Framework\TestCase
{
    private function getView()
    {
        $app = \Zend\Mvc\Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        return $serviceManager->get('ViewRenderer');
    }

    public function testHelperWorks()
    {
        $html = $this->getView()->htmlImg('http://example.com/image.png');

        $this->assertContains('<img src="http&#x3A;&#x2F;&#x2F;example.com&#x2F;image.png"', $html);
    }

    public function testShuffleAttributeUnsets()
    {
        $html = $this->getView()->htmlImg([
            'src'     => 'http://example.com/image',
            'shuffle' => true
        ]);

        $this->assertNotContains('shuffle', $html);
    }
}
