<?php

declare(strict_types=1);

namespace Autowp\ZFComponents\Db;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\Feature\SequenceFeature;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\ServiceLocatorInterface;

use function sprintf;

class TableManager implements ServiceLocatorInterface
{
    /** @var array */
    private array $specs = [];

    /** @var array */
    private array $tables = [];

    /** @var Adapter */
    private Adapter $adapter;

    public function __construct(Adapter $adapter, array $specs)
    {
        $this->adapter = $adapter;
        $this->specs   = $specs;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param  string $name
     * @return TableGateway
     */
    public function build($name, ?array $options = null)
    {
        if (! isset($this->specs[$name])) {
            throw new ServiceNotFoundException(sprintf(
                'Unable to create service "%s"',
                $name
            ));
        }

        $spec = $this->specs[$name];

        $platform     = $this->adapter->getPlatform();
        $platformName = $platform->getName();

        $features = [];
        if ($platformName === 'PostgreSQL' && isset($spec['sequences'])) {
            foreach ($spec['sequences'] as $field => $sequence) {
                $features[] = new SequenceFeature($field, $sequence);
            }
        }

        return new TableGateway($name, $this->adapter, $features);
    }

    /**
     * @param string $id Identifier of the entry to look for.
     * @return mixed Entry.
     */
    public function get($id)
    {
        if (! isset($this->tables[$id])) {
            $this->tables[$id] = $this->build($id);
        }

        return $this->tables[$id];
    }

    /**
     * @param string $id Identifier of the entry to look for.
     * @return bool
     */
    public function has($id)
    {
        return isset($this->specs[$id]);
    }
}
