<?php

return [
    'modules' => [
        'Zend\Filter',
        'Zend\Router',
        'Autowp\ZFComponents'
    ],
    'module_listener_options' => [
        'module_paths' => [
            './vendor',
        ],
        'config_glob_paths' => [
            'test/_files/config/autoload/local.php',
        ],
    ]
];
