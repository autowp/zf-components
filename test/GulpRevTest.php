<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use Autowp\ZFComponents\GulpRev;
use Autowp\ZFComponents\GulpRevException;
use Laminas\Mvc\Application;
use Laminas\View\Renderer\RendererInterface;
use PHPUnit\Framework\TestCase;

class GulpRevTest extends TestCase
{
    private function getView(): RendererInterface
    {
        $app = Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        return $serviceManager->get('ViewRenderer');
    }

    /**
     * @throws GulpRevException
     */
    public function testManifestRequired(): void
    {
        $this->expectException(GulpRevException::class);
        new GulpRev([
            'manifests' => [
                [
                    'prefix' => '/',
                ],
            ],
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
        $view = $this->getView();

        $view->gulpRev([
            'scripts' => [
                'test.js',
            ],
        ]);

        $html = $view->headScript()->toString();

        $this->assertStringContainsString('&#x2F;test-81bcd394dd.js', $html);
    }

    public function testAddStylesheet(): void
    {
        $view = $this->getView();

        $view->gulpRev([
            'stylesheets' => [
                'test.css',
            ],
        ]);

        $html = $view->headLink()->toString();

        $this->assertStringContainsString('&#x2F;test-81bcd394dd.css', $html);
    }
}
