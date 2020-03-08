<?php

declare(strict_types=1);

namespace AutowpTest\ZFComponents;

use Laminas\Http\Request;
use Laminas\Mvc\Application;
use Laminas\Router\RouteMatch;
use Laminas\View\Renderer\RendererInterface;
use PHPUnit\Framework\TestCase;

class WildcardSafeRouteTest extends TestCase
{
    private $app;

    private function getApp(): Application
    {
        if ($this->app === null) {
            $this->app = Application::init(require __DIR__ . '/_files/config/application.config.php');
        }

        return $this->app;
    }

    private function getView(): RendererInterface
    {
        $serviceManager = $this->getApp()->getServiceManager();

        return $serviceManager->get('ViewRenderer');
    }

    public function testAssemble(): void
    {
        $url = $this->getView()->url('example/params', [
            'param1' => 'value1',
            'param2' => 'value2',
        ]);

        $this->assertEquals('/example/param1/value1/param2/value2', $url);
    }

    public function testMatch(): void
    {
        $serviceManager = $this->getApp()->getServiceManager();
        $router         = $serviceManager->get('HttpRouter');

        $request = Request::fromString("GET /example/param1/value1/param2/value2 HTTP/1.0\n");

        $match = $router->match($request);

        $this->assertNotNull($match);
        $this->assertInstanceOf(RouteMatch::class, $match);

        $this->assertEquals('example/params', $match->getMatchedRouteName());
        $this->assertEquals([
            'param1' => 'value1',
            'param2' => 'value2',
        ], $match->getParams());
    }

    public function testAssembleWithEmptyParams(): void
    {
        $url = $this->getView()->url('example/params', []);

        $this->assertEquals('/example', $url);
    }

    public function testAssembleWithCustomDelimiter(): void
    {
        $url = $this->getView()->url('example2/params', [
            'param1' => 'value1',
            'param2' => 'value2',
        ]);

        $this->assertEquals('/example2/param1=value1/param2=value2', $url);
    }

    public function testMatchWithCustomDelimiter(): void
    {
        $serviceManager = $this->getApp()->getServiceManager();
        $router         = $serviceManager->get('HttpRouter');

        $request = Request::fromString("GET /example2/param1=value1/param2=value2 HTTP/1.0\n");

        $match = $router->match($request);

        $this->assertNotNull($match);
        $this->assertInstanceOf(RouteMatch::class, $match);

        $this->assertEquals('example2/params', $match->getMatchedRouteName());
        $this->assertEquals([
            'param1' => 'value1',
            'param2' => 'value2',
        ], $match->getParams());
    }

    public function testAssembleWithExcludedParameters(): void
    {
        $url = $this->getView()->url('example/params', [
            'param1'     => 'value1',
            'param2'     => 'value2',
            'controller' => 'test',
            'action'     => 'test',
        ]);

        $this->assertEquals('/example/param1/value1/param2/value2', $url);
    }

    public function testMatchWithExcludedParameters(): void
    {
        $serviceManager = $this->getApp()->getServiceManager();
        $router         = $serviceManager->get('HttpRouter');

        $request = Request::fromString(
            "GET /example/param1/value1/param2/value2/controller/test/action/test HTTP/1.0\n"
        );

        $match = $router->match($request);

        $this->assertNotNull($match);
        $this->assertInstanceOf(RouteMatch::class, $match);

        $this->assertEquals('example/params', $match->getMatchedRouteName());
        $this->assertEquals([
            'param1' => 'value1',
            'param2' => 'value2',
        ], $match->getParams());
    }
}
