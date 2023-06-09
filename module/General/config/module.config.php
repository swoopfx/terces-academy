<?php

declare(strict_types=1);

namespace General;

use General\Service\ActiveCampaignService;
use General\Service\Factory\ActiveCampaignServiceFactory;
use General\Service\Factory\GeneralServiceFactory;
use General\Service\GeneralService;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            // 'home' => [
            //     'type'    => Literal::class,
            //     'options' => [
            //         'route'    => '/',
            //         'defaults' => [
            //             'controller' => Controller\IndexController::class,
            //             'action'     => 'index',
            //         ],
            //     ],
            // ],
            // 'application' => [
            //     'type'    => Segment::class,
            //     'options' => [
            //         'route'    => '/application[/:action]',
            //         'defaults' => [
            //             'controller' => Controller\IndexController::class,
            //             'action'     => 'index',
            //         ],
            //     ],
            // ],
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
    'controllers' => [
        'factories' => [
            // Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    "service_manager" => [
        "factories" => [
            GeneralService::class => GeneralServiceFactory::class,
            ActiveCampaignService::class => ActiveCampaignServiceFactory::class
        ]
    ],
    'view_manager' => [
      
        'template_map' => [
            // 'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            // 'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            // 'error/404'               => __DIR__ . '/../view/error/404.phtml',
            // 'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
