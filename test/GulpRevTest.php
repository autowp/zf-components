<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use Autowp\ZFComponents\GulpRev;
use Autowp\ZFComponents\GulpRevException;
use Laminas\Mvc\Application;
use PHPUnit\Framework\TestCase;

class GulpRevTest extends TestCase
{
    /**
     * @throws GulpRevException
     */
    public function testManifestRequired(): void
    {
        $this->expectException(GulpRevException::class);
        new GulpRev([
            'prefix' => '/',
        ]);
    }

    /**
     * @throws GulpRevException
     */
    public function testPrefixRequired(): void
    {
        $this->expectException(GulpRevException::class);
        new GulpRev([
            'manifest' => 'not-existent-file.json',
        ]);
    }

    /**
     * @throws GulpRevException
     */
    public function testNotFailsOnMissingManifest(): void
    {
        $service = new GulpRev([
            'manifest' => 'not-existent-file.json',
            'prefix'   => '/',
        ]);

        $service->getRevUrl('test.css');

        $this->assertTrue(true);
    }

    /**
     * @throws GulpRevException
     */
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
