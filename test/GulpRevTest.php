<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use Autowp\ZFComponents\GulpRev;
use Laminas\Mvc\Application;
use PHPUnit\Framework\TestCase;

class GulpRevTest extends TestCase
{
    public function testNotFailsOnMissingManifest(): void
    {
        $service = new GulpRev([
            'manifest' => 'not-existent-file.json',
            'prefix'   => '/',
        ]);

        $service->getRevUrl('test.css');

        $this->assertTrue(true);
    }

    public function testPrefixPrepends(): void
    {
        $service = new GulpRev([
            'manifest' => 'not-existent-file.json',
            'prefix'   => 'http://prefix/',
        ]);

        $result = $service->getRevUrl('test.css');

        $this->assertEquals('http://prefix/test.css', $result);
    }

    public function testScriptRevAppends(): void
    {
        $app = Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        $view = $serviceManager->get('ViewRenderer');

        $view->gulpRev([
            'scripts' => [
                'test.js',
            ],
        ]);

        $html = $view->headScript()->toString();

        $this->assertStringContainsString('&#x2F;test-81bcd394dd.js', $html);
    }
}
