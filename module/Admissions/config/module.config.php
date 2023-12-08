<?php

namespace Admissions;

use Admissions\Controller\AdmissionsController;
use Admissions\Controller\Factory\AdmissionsControllerFactory;
use Admissions\Controller\Factory\PortalControllerFactory;
use Admissions\Controller\Factory\SendmoneyControllerFactory;
use Admissions\Controller\PortalController;
use Admissions\Controller\SendmoneyController;
use Laminas\Router\Http\Segment;

return [
    "controllers" => [
        "factories" => [
            AdmissionsController::class => AdmissionsControllerFactory::class,
            PortalController::class => PortalControllerFactory::class,
            SendmoneyController::class => SendmoneyControllerFactory::class
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

    "view_manager" => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'template_map' => [
            'admissions/layout'           => __DIR__ . '/../view/layout/admissionsLayout.phtml',
            'sendmoney/layout'           => __DIR__ . '/../view/layout/sendmoneyLayout.phtml',
            'pre/admissions/layout'           => __DIR__ . '/../view/layout/preLayout.phtml',
        ]
    ],
    'router' => [
        'routes' => [
            'admissions' => [
                'type'    => Segment::class,
                'options' => [

                    'route'    => '/admissions[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => AdmissionsController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'portal' => [
                'type'    => Segment::class,
                'options' => [

                    'route'    => '/portal[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => PortalController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            'sendmoney' => [
                'type'    => Segment::class,
                'options' => [

                    'route'    => '/sendmoney[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => SendmoneyController::class,
                        'action'     => 'index',
                    ],
                ],
            ]
        ]
    ]
];
