<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use DateTime;
use Laminas\Mvc\Application;
use Laminas\View\Renderer\RendererInterface;
use PHPUnit\Framework\TestCase;

class HumanTimeTest extends TestCase
{
    private function getView(): RendererInterface
    {
        $app = Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        return $serviceManager->get('ViewRenderer');
    }

    public function testHelperWorks(): void
    {
        $html = $this->getView()->humanTime(new DateTime());

        $this->assertEquals('now', $html);
    }
}
