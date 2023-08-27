<?php

declare(strict_types=1);

namespace Application;

use Application\Controller\AdminController;
use Application\Controller\AppController;
use Application\Controller\Factory\AdminControllerFactory;
use Application\Controller\Factory\AppControllerFactory;
use Application\Controller\Factory\IndexControllerFactory;
use Application\Service\Factory\TransactionServiceFactory;
use Application\Service\PaypalService;
use Application\Service\Factory\PaypalServiceFactory;
use Application\Service\TransactionService;
use Application\View\Factory\IsSuscribedFactory;
use Application\View\IsSubscribed;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
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

            'app' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/app[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => AppController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

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
        ],
    ],
    'controllers' => [
        'factories' => [
            // Controller\IndexController::class => IndexControllerFactory::class,
            Controller\IndexController::class => IndexControllerFactory::class,
            AppController::class => AppControllerFactory::class,
            AdminController::class => AdminControllerFactory::class
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
    "service_manager" => [
        "factories" => [
            TransactionService::class => TransactionServiceFactory::class,
            PaypalService::class => PaypalServiceFactory::class
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            "admin-layout"  => __DIR__ . '/../view/layout/admin-layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',

            // partials
            "partials_newsletter" => __DIR__ . '/../view/partials/newsletter.phtml',
            "partials_faq" => __DIR__ . '/../view/partials/faq.phtml',
            "partials_courselist" => __DIR__ . '/../view/partials/course_list.phtml',
            "partials_schedule_service" => __DIR__ . '/../view/partials/schedule_service.phtml',
            "partials_coming_free_training" => __DIR__ . '/../view/partials/coming_free_training.phtml',
            "partial_quiz" => __DIR__ . '/../view/partials/quiz_partial.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ]
    ],

    "view_helpers" => [
        "factories" => [
            IsSubscribed::class => IsSuscribedFactory::class
        ],
        "aliases" => [
            "isSubscribed" => IsSubscribed::class
        ]
    ]
];
