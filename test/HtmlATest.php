<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use Laminas\Mvc\Application;
use Laminas\View\Renderer\RendererInterface;
use PHPUnit\Framework\TestCase;

class HtmlATest extends TestCase
{
    private function getView(): RendererInterface
    {
        $app = Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        return $serviceManager->get('ViewRenderer');
    }

    public function testHelperWorks(): void
    {
        $html = $this->getView()->htmlA('http://example.com', 'example.com');

        $this->assertStringContainsString('<a href="http&#x3A;&#x2F;&#x2F;example.com">example.com</a>', $html);
    }

    public function testUrlShorthandWorks(): void
    {
        $html = $this->getView()->htmlA()->url('http://example.com');

        $this->assertStringContainsString('<a href="http&#x3A;&#x2F;&#x2F;example.com">example.com</a>', $html);
    }

    public function testShuffleAttributeUnsets(): void
    {
        $html = $this->getView()->htmlA([
            'href'    => 'http://example.com',
            'shuffle' => true,
        ], 'example.com');

        $this->assertStringContainsString('shuffle', $html);
    }
}
