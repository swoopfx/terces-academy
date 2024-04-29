<?php

namespace Admin;

use Admin\Controller\AdminController;
use Admin\Controller\AdminProcessController;
use Admin\Controller\Factory\AdminProcessControllerFactory;
use Admin\Controller\Factory\ZoomControllerFactory;
use Admin\Controller\ZoomController;
use Admin\Controller\Factory\AdminControllerFactory;
use Admin\Controller\Factory\InternshipControllerFactory;
use Admin\Controller\Factory\OracleControllerFactory;
use Admin\Controller\InternshipController;
use Admin\Controller\OracleController;
use Laminas\Router\Http\Segment;

return [
    "view_manager" => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'template_map' => [
            'admin/main/menu'           => __DIR__ . '/../view/partial/admin-menu.phtml',
            'admin/oraclep6/menu'           => __DIR__ . '/../view/partial/oracle-menu.phtml',
        ]
    ],
    "controllers" => [
        "factories" => [
            ZoomController::class => ZoomControllerFactory::class,
            AdminController::class => AdminControllerFactory::class,
            AdminProcessController::class => AdminProcessControllerFactory::class,
            InternshipController::class => InternshipControllerFactory::class,
            OracleController::class => OracleControllerFactory::class,
        ],
        "aliases" => [
            "admin-intern" => InternshipController::class,
            "oracle" => OracleController::class
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
            ],

            'admin-general' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/admins[/:controller[/:action[/:id]]]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => AdminController::class,
                        'action'     => 'index',
                        'id' => '[a-zA-Z0-9_-]*'
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
