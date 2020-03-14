<?php

declare(strict_types=1);

namespace Autowp\ZFComponents;

use PDO;

return [
    'gulp-rev' => [
        'manifest' => __DIR__ . '/../../rev-manifest.json',
        'prefix'   => '/',
    ],
    'mail'     => [
        'transport' => [
            'type' => 'in-memory',
        ],
    ],
    'tables'   => [
        'foo' => [
            'sequences' => 'foo_id_seq',
        ],
    ],
    'db'       => [
        'driver'         => 'Pdo',
        'pdodriver'      => 'mysql',
        'charset'        => 'utf8',
        'host'           => 'example',
        'port'           => 3306,
        'username'       => 'username',
        'password'       => 'password',
        'dbname'         => 'bar',
        'driver_options' => [PDO::ATTR_PERSISTENT => true],
    ],
];
