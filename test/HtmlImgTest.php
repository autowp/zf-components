<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use Laminas\Mvc\Application;
use Laminas\View\Renderer\RendererInterface;
use PHPUnit\Framework\TestCase;

class HtmlImgTest extends TestCase
{
    private function getView(): RendererInterface
    {
        $app = Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        return $serviceManager->get('ViewRenderer');
    }

    public function testHelperWorks(): void
    {
        $html = $this->getView()->htmlImg('http://example.com/image.png');

        $this->assertStringContainsString('<img src="http&#x3A;&#x2F;&#x2F;example.com&#x2F;image.png"', $html);
    }

    public function testShuffleAttributeUnsets(): void
    {
        $html = $this->getView()->htmlImg([
            'src'     => 'http://example.com/image',
            'shuffle' => true,
        ]);

        $this->assertStringNotContainsStringIgnoringCase('shuffle', $html);
    }
}
