<?php

namespace Admin;

use Admin\Controller\AdminController;
use Admin\Controller\AdminProcessController;
use Admin\Controller\Factory\AdminProcessControllerFactory;
use Admin\Controller\Factory\ZoomControllerFactory;
use Admin\Controller\ZoomController;
use Admin\Controller\Factory\AdminControllerFactory;
use Laminas\Router\Http\Segment;

return [
    "view_manager" => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    "controllers" => [
        "factories" => [
            ZoomController::class => ZoomControllerFactory::class,
            AdminController::class => AdminControllerFactory::class,
            AdminProcessController::class => AdminProcessControllerFactory::class
        ]

    ],
    'router' => [
        'routes' => [

            'admin' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/admin[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => AdminController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            'admin-process' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/adminprocess[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => AdminProcessController::class,
                        'action'     => 'index',
                    ],
                ],
            ]
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
];
