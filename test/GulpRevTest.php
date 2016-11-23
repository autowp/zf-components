<?php

namespace AutowpTest\ZFComponents;

use Autowp\ZFComponents\GulpRev;

class GulpRevTest extends \PHPUnit_Framework_TestCase
{
    public function testNotFailsOnMissingManifest()
    {
        $service = new GulpRev([
            'manifest' => 'not-existent-file.json',
            'prefix'   => '/'
        ]);

        $result = $service->getRevUrl('test.css');
    }

    public function testPrefixPrepends()
    {
        $service = new GulpRev([
            'manifest' => 'not-existent-file.json',
            'prefix'   => 'http://prefix/'
        ]);

        $result = $service->getRevUrl('test.css');

        $this->assertEquals('http://prefix/test.css', $result);
    }

    public function testScriptRevAppends()
    {
        $app = \Zend\Mvc\Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        $view = $serviceManager->get('ViewRenderer');

        $view->gulpRev([
            'scripts' => [
                'test.js'
            ]
        ]);

        $html = $view->headScript()->toString();

        $this->assertContains('/test-81bcd394dd.js', $html);
    }
}
