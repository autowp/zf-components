<?php

namespace Autowp\ZFComponents\Db;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\Feature\SequenceFeature;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;

class TableManager implements ServiceLocatorInterface
{
    /**
     * @var array
     */
    private $specs = [];

    /**
     * @var array
     */
    private $tables = [];

    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(Adapter $adapter, array $specs)
    {
        $this->adapter = $adapter;
        $this->specs = $specs;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function build($name, array $options = null)
    {
        if (! isset($this->specs[$name])) {
            throw new ServiceNotFoundException(sprintf(
                'Unable to create service "%s"',
                $name
            ));
        }

        $spec = $this->specs[$name];

        $platform = $this->adapter->getPlatform();
        $platformName = $platform->getName();

        $features = [];
        if ($platformName == 'PostgreSQL') {
            if (isset($spec['sequences'])) {
                foreach ($spec['sequences'] as $field => $sequence) {
                    $features[] = new SequenceFeature($field, $sequence);
                }
            }
        }

        return new TableGateway($name, $this->adapter, $features);
    }

    public function get($id)
    {
        if (! isset($this->tables[$id])) {
            $this->tables[$id] = $this->build($id);
        }

        return $this->tables[$id];
    }

    public function has($id)
    {
        return isset($this->specs[$id]);
    }
}
