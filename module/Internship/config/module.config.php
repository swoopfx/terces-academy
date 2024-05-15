<?php

namespace Internship;

use Internship\Controller\ClassesController;
use Internship\Controller\CoursesController;
use Internship\Controller\Factory\ClassesControllerFactory;
use Internship\Controller\Factory\CoursesControllerFactory;
use Internship\Controller\Factory\InternshipControllerFactory;
use Internship\Controller\Factory\ProjectsControllerFactory;
use Internship\Controller\Factory\ResourceControllerFactory;
use Internship\Controller\Factory\ToolsControllerFactory;
use Internship\Controller\InternshipController;
use Internship\Controller\ProjectController;
use Internship\Controller\ResourceController;
use Internship\Controller\ToolsController;
use Internship\Service\CourseService;
use Internship\Service\Factory\CourseServiceFactory;
use Laminas\Router\Http\Segment;

return [
    "controllers" => [
        "factories" => [
            InternshipController::class => InternshipControllerFactory::class,
            ProjectController::class => ProjectsControllerFactory::class,
            ResourceController::class => ResourceControllerFactory::class,
            ToolsController::class => ToolsControllerFactory::class,
            ClassesController::class => ClassesControllerFactory::class,
            CoursesController::class => CoursesControllerFactory::class
        ],
        "aliases" => [
            "internship" => InternshipController::class,
            "resources" => ResourceController::class,
            "tools" => ToolsController::class,
            "classes" => ClassesController::class,
            "courses" => CoursesController::class
        ]
    ],

    "service_manager" => [
        "factories" => [
            CourseService::class => CourseServiceFactory::class
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
            'intern/layout'           => __DIR__ . '/../view/layout/intern-layout.phtml',
            'partial/menu-internship'           => __DIR__ . '/../view/partial/intern-menu.phtml',
            'partial/board-menu'           => __DIR__ . '/../view/partial/board-menu.phtml',
            'partial/course-info-menu'           => __DIR__ . '/../view/partial/course-info-menu.phtml',
            'partial/my-course-menu'           => __DIR__ . '/../view/partial/my-course-menu.phtml',
            'partial/featured-courses'           => __DIR__ . '/../view/partial/featured-courses.phtml',
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
