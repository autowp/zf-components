<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use DateInterval;
use DateTime;
use Exception;
use Laminas\Mvc\Application;
use Laminas\View\Renderer\RendererInterface;
use PHPUnit\Framework\TestCase;

use function time;

class HumanDateTest extends TestCase
{
    private function getView(): RendererInterface
    {
        $app = Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        return $serviceManager->get('ViewRenderer');
    }

    /**
     * @dataProvider periodProvider
     * @throws Exception
     */
    public function testSiblingDates(string $interval, string $expected, bool $invert): void
    {
        $interval         = new DateInterval($interval);
        $interval->invert = $invert;
        $output           = $this->getView()->humanDate((new DateTime())->add($interval));

        $this->assertEquals($expected, $output);
    }

    public static function periodProvider(): array
    {
        return [
            ['PT0M', 'today', false],
            ['P1D', 'yesterday', true],
            ['P1D', 'tomorrow', false],
        ];
    }

    /**
     * @throws Exception
     */
    public function testDates(): void
    {
        $date   = DateTime::createFromFormat(DateTime::ISO8601, '2000-01-01T00:00:00+0200');
        $output = $this->getView()->humanDate($date);

        $this->assertEquals('January 1, 2000', $output);
    }

    /**
     * @throws Exception
     */
    public function testTimestamp(): void
    {
        $output = $this->getView()->humanDate(time());

        $this->assertEquals('today', $output);
    }
}
