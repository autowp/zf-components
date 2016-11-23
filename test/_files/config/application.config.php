<?php

return [
    'modules' => [
        'Zend\Filter',
        'Zend\Router',
        'Zend\I18n',
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
