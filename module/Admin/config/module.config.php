<?php

namespace Admin;

use Laminas\Router\Http\Segment;

return [
    'router' => [
        'routes' => [

            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ]
    ],
    "controllers" => [
        "factories" => []
    ]
];
