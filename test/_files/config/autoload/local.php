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
    ]
];
