<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use DateInterval;
use DateTime;
use Exception;
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

    /**
     * @dataProvider futureTestProvider
     * @throws Exception
     */
    public function testFuture(string $interval, string $expected): void
    {
        $html = $this->getView()->humanTime((new DateTime())->add(new DateInterval($interval)));

        $this->assertEquals($expected, $html);
    }

    public static function futureTestProvider(): array
    {
        return [
            ['PT0S', 'now'],
            ['PT55S', 'in a minute'],
            ['PT1S', 'in few seconds'],
        ];
    }

    /**
     * @dataProvider pastTestProvider
     * @throws Exception
     */
    public function testPast(string $interval, string $expected): void
    {
        $html = $this->getView()->humanTime((new DateTime())->sub(new DateInterval($interval)));

        $this->assertEquals($expected, $html);
    }

    public static function pastTestProvider(): array
    {
        return [
            ['PT1M', 'a minute ago'],
            ['PT20S', 'few seconds ago'],
            ['PT55M', 'an hour ago'],
        ];
    }
}
