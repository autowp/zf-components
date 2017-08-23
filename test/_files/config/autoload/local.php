<?php

namespace Autowp\ZFComponents;

use Zend\Router\Http\Literal;

return [
    'gulp-rev' => [
        'manifest' => __DIR__ . '/../../rev-manifest.json',
        'prefix'   => '/'
    ],
    'router' => [
        'routes' => [
            'example' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/example'
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'params' => [
                        'type' => Router\Http\WildcardSafe::class
                    ]
                ]
            ],
            'example2' => [
                'type'    => Literal::class,
                'options' => [
                    'route' => '/example2'
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'params' => [
                        'type' => Router\Http\WildcardSafe::class,
                        'options' => [
                            'key_value_delimiter' => '='
                        ]
                    ],
                ]
            ]
        ]
    ],
    'mail' => [
        'transport' => [
            'type' => 'in-memory'
        ],
    ],
    'tables' => [
        'foo' => [
            'sequences' => 'foo_id_seq'
        ]
    ],
    'db' => [
        'driver'    => 'Pdo',
        'pdodriver' => 'mysql',
        'charset'   => 'utf8',
        'host'      => 'example',
        'port'      => 3306,
        'username'  => 'username',
        'password'  => 'password',
        'dbname'    => 'bar',
        'driver_options' => [\PDO::ATTR_PERSISTENT => true]
    ]
];
