<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\Router\Http;

use Laminas\Router\Http\RouteMatch;
use Laminas\Router\Http\Wildcard;
use Laminas\Stdlib\RequestInterface as Request;

use function array_merge;
use function array_replace;
use function array_shift;
use function count;
use function explode;
use function implode;
use function is_array;
use function method_exists;
use function rawurldecode;
use function rawurlencode;
use function strlen;
use function substr;

/**
 * WildcardSafe route.
 */
class WildcardSafe extends Wildcard
{
    private $exclude = ['controller', 'action'];

    /**
     * match(): defined by RouteInterface interface.
     *
     * @see    \Zend\Router\RouteInterface::match()
     *
     * @param  int|null $pathOffset
     * @return RouteMatch|null
     */
    public function match(Request $request, $pathOffset = null)
    {
        if (! method_exists($request, 'getUri')) {
            return null;
        }

        $uri  = $request->getUri();
        $path = $uri->getPath() ?: '';

        if ($path === '/') {
            $path = '';
        }

        if ($pathOffset !== null) {
            $path = substr($path, $pathOffset) ?: '';
        }

        $matches = [];
        $params  = explode($this->paramDelimiter, $path);

        if (count($params) > 1 && ($params[0] !== '')) {
            return null;
        }

        if ($this->keyValueDelimiter === $this->paramDelimiter) {
            $count = count($params);

            for ($i = 1; $i < $count; $i += 2) {
                if (isset($params[$i + 1])) {
                    $key   = rawurldecode($params[$i]);
                    $value = rawurldecode($params[$i + 1]);
                    if (isset($matches[$key])) {
                        if (! is_array($matches[$key])) {
                            $matches[$key] = [$matches[$key]];
                        }
                        $matches[$key][] = $value;
                    } else {
                        $matches[$key] = $value;
                    }
                }
            }
        } else {
            array_shift($params);

            foreach ($params as $param) {
                $param = explode($this->keyValueDelimiter, $param, 2);

                if (isset($param[1])) {
                    $key   = rawurldecode($param[0]);
                    $value = rawurldecode($param[1]);

                    if (isset($matches[$key])) {
                        if (! is_array($matches[$key])) {
                            $matches[$key] = [$matches[$key]];
                        }
                        $matches[$key][] = $value;
                    } else {
                        $matches[$key] = $value;
                    }
                }
            }
        }

        foreach ($this->exclude as $key) {
            unset($matches[$key]);
        }

        return new RouteMatch(array_merge($this->defaults, $matches), strlen($path));
    }

    /**
     * @see    \Laminas\Router\RouteInterface::assemble()
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * assemble(): Defined by RouteInterface interface.
     *
     * @return mixed
     */
    public function assemble(array $params = [], array $options = [])
    {
        $elements              = [];
        $mergedParams          = array_replace($this->defaults, $params);
        $this->assembledParams = [];

        foreach ($this->exclude as $key) {
            unset($mergedParams[$key]);
        }

        if ($mergedParams) {
            foreach ($mergedParams as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $ivalue) {
                        $elements[] = rawurlencode($key) . $this->keyValueDelimiter . rawurlencode($ivalue);
                    }
                } else {
                    $elements[] = rawurlencode($key) . $this->keyValueDelimiter . rawurlencode($value);
                }
                $this->assembledParams[] = $key;
            }

            return $this->paramDelimiter . implode($this->paramDelimiter, $elements);
        }

        return '';
    }
}
