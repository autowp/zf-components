<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use Autowp\ZFComponents;
use Laminas\Mvc\Application;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testConfig(): void
    {
        $provider = new ZFComponents\ConfigProvider();
        $config   = $provider();

        $this->assertArrayHasKey('dependencies', $config);
        $this->assertArrayHasKey('gulp-rev', $config);
        $this->assertArrayHasKey('filters', $config);
        $this->assertArrayHasKey('view_helpers', $config);
    }

    public function testGulpRevRegistered(): void
    {
        $app = Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        $this->assertInstanceOf(ZFComponents\GulpRev::class, $serviceManager->get(ZFComponents\GulpRev::class));
    }

    public function testFiltersRegistered(): void
    {
        $app = Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        $filterManager = $serviceManager->get('FilterManager');

        $this->assertInstanceOf(ZFComponents\Filter\FilenameSafe::class, $filterManager->get('filenameSafe'));
        $this->assertInstanceOf(ZFComponents\Filter\SingleSpaces::class, $filterManager->get('singleSpaces'));
        $this->assertInstanceOf(ZFComponents\Filter\Transliteration::class, $filterManager->get('transliteration'));
    }

    public function testViewHelpersRegistered(): void
    {
        $app = Application::init(require __DIR__ . '/_files/config/application.config.php');

        $serviceManager = $app->getServiceManager();

        $helperManager = $serviceManager->get('ViewRenderer')->getHelperPluginManager();

        $this->assertInstanceOf(ZFComponents\View\Helper\GulpRev::class, $helperManager->get('gulpRev'));
        $this->assertInstanceOf(ZFComponents\View\Helper\htmlA::class, $helperManager->get('htmlA'));
        $this->assertInstanceOf(ZFComponents\View\Helper\htmlImg::class, $helperManager->get('htmlImg'));
    }
}
