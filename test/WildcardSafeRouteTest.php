<?php

namespace AutowpTest\ZFComponents;

class WildcardSafeRouteTest extends \PHPUnit\Framework\TestCase
{
    private $app = null;

    private function getApp()
    {
        if ($this->app === null) {
            $this->app = \Zend\Mvc\Application::init(require __DIR__ . '/_files/config/application.config.php');
        }

        return $this->app;
    }

    private function getView()
    {
        $serviceManager = $this->getApp()->getServiceManager();

        return $serviceManager->get('ViewRenderer');
    }

    public function testAssemble()
    {
        $url = $this->getView()->url('example/params', [
            'param1' => 'value1',
            'param2' => 'value2'
        ]);

        $this->assertEquals('/example/param1/value1/param2/value2', $url);
    }

    public function testMatch()
    {
        $serviceManager = $this->getApp()->getServiceManager();
        $router = $serviceManager->get('HttpRouter');

        $request = \Zend\Http\Request::fromString("GET /example/param1/value1/param2/value2 HTTP/1.0\n");

        $match = $router->match($request);

        $this->assertNotNull($match);
        $this->assertInstanceOf(\Zend\Router\RouteMatch::class, $match);

        $this->assertEquals('example/params', $match->getMatchedRouteName());
        $this->assertEquals([
            'param1' => 'value1',
            'param2' => 'value2'
        ], $match->getParams());
    }

    public function testAssembleWithEmptyParams()
    {
        $url = $this->getView()->url('example/params', []);

        $this->assertEquals('/example', $url);
    }

    public function testAssembleWithCustomDelimiter()
    {
        $url = $this->getView()->url('example2/params', [
            'param1' => 'value1',
            'param2' => 'value2'
        ]);

        $this->assertEquals('/example2/param1=value1/param2=value2', $url);
    }

    public function testMatchWithCustomDelimiter()
    {
        $serviceManager = $this->getApp()->getServiceManager();
        $router = $serviceManager->get('HttpRouter');

        $request = \Zend\Http\Request::fromString("GET /example2/param1=value1/param2=value2 HTTP/1.0\n");

        $match = $router->match($request);

        $this->assertNotNull($match);
        $this->assertInstanceOf(\Zend\Router\RouteMatch::class, $match);

        $this->assertEquals('example2/params', $match->getMatchedRouteName());
        $this->assertEquals([
            'param1' => 'value1',
            'param2' => 'value2'
        ], $match->getParams());
    }

    public function testAssembleWithExcludedParameters()
    {
        $url = $this->getView()->url('example/params', [
            'param1'     => 'value1',
            'param2'     => 'value2',
            'controller' => 'test',
            'action'     => 'test'
        ]);

        $this->assertEquals('/example/param1/value1/param2/value2', $url);
    }

    public function testMatchWithExcludedParameters()
    {
        $serviceManager = $this->getApp()->getServiceManager();
        $router = $serviceManager->get('HttpRouter');

        $request = \Zend\Http\Request::fromString(
            "GET /example/param1/value1/param2/value2/controller/test/action/test HTTP/1.0\n"
        );

        $match = $router->match($request);

        $this->assertNotNull($match);
        $this->assertInstanceOf(\Zend\Router\RouteMatch::class, $match);

        $this->assertEquals('example/params', $match->getMatchedRouteName());
        $this->assertEquals([
            'param1' => 'value1',
            'param2' => 'value2'
        ], $match->getParams());
    }
}
