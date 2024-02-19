<?php

namespace Internship;

use Internship\Controller\Factory\InternshipControllerFactory;
use Internship\Controller\Factory\ProjectsControllerFactory;
use Internship\Controller\Factory\ResourceControllerFactory;
use Internship\Controller\InternshipController;
use Internship\Controller\ProjectController;
use Internship\Controller\ResourceController;
use Laminas\Router\Http\Segment;

return [
    "controllers" => [
        "factories" => [
            InternshipController::class => InternshipControllerFactory::class,
            ProjectController::class => ProjectsControllerFactory::class,
            ResourceController::class => ResourceControllerFactory::class,
        ],
        "aliases" => [
            "internship" => InternshipController::class,
            "resources" => ResourceController::class
        ]
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
            'internship/layout'           => __DIR__ . '/../view/layout/internLayout.phtml',
        ]
    ],
    'router' => [
        'routes' => [
            'internship' => [
                'type'    => Segment::class,
                'options' => [

                    'route'    => '/internships[/:controller[/:action[/:id]]]',
                    'constraints' => [
                        'controller' => '[a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => "internship",
                        'action'     => 'dashboard',
                    ],
                ],
            ],
        ]
    ]
];
