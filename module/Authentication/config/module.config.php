<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Controller\AuthController;
use Authentication\Controller\Factory\AuthControllerFactory;
use Authentication\Entity\User;
use Authentication\Service\Factory\AuthenticationFactory;
use Doctrine\ORM\EntityManager;
use Laminas\Authentication\AuthenticationService;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    "service_manager" => [
        "factories" => [
            "Laminas\Authentication\AuthenticationService" => AuthenticationFactory::class,
        ],
        "aliases" => [
           
            "authentication_service" => "Laminas\Authentication\AuthenticationService"
        ]
    ],
    'router' => [
        'routes' => [
            'login' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'register' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/register[/:id]',
                    "constraints" => [
                        'id' => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action'     => 'register',
                    ],
                ],
            ],

            'auth' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/auth[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'doctrine' => [
        'configuration' => array(
            'orm_default' => array(
                'generate_proxies' => true
            )
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => EntityManager::class,
                'identity_class' => User::class,
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => 'Authentication\Service\UserService::verifyHashedPassword'
            )
        ),
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
    'controllers' => [
        'factories' => [
            AuthController::class => AuthControllerFactory::class,
        ],
    ],
    'view_manager' => [

        'template_map' => [],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
