<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'lmc_cors' => [
        'allowed_origins' => ['*'],
        'allowed_methods' => ['*'],
        'allowed_headers' => ['*']
    ],
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
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'estados' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/estados',
                    'defaults' => [
                        'controller' => 'Application\Controller\EstadosController',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // Segment route for viewing one blog post
                    'geral-bid' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/[:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
            'municipios' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/municipios',
                    'defaults' => [
                        'controller' => 'Application\Controller\MunicipiosController',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // Segment route for viewing one blog post
                    'geral-bid' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/[:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
            'escolas' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/escolas',
                    'defaults' => [
                        'controller' => 'Application\Controller\EscolasController',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // Segment route for viewing one blog post
                    'geral-bid' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/[:action[/:id[/:municipio]]]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
            'questionarios' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/questionarios',
                    'defaults' => [
                        'controller' => 'Application\Controller\QuestionariosController',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // Segment route for viewing one blog post
                    'geral-bid' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/[:action[/:param1[/:param2[/:param3]]]]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
            'perguntas' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/perguntas',
                    'defaults' => [
                        'controller' => 'Application\Controller\PerguntasController',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // Segment route for viewing one blog post
                    'geral-bid' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/[:action[/:param1[/:param2[/:param3]]]]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
            'respostas' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/respostas',
                    'defaults' => [
                        'controller' => 'Application\Controller\RespostasController',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // Segment route for viewing one blog post
                    'geral-bid' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/[:action[/:param1[/:param2[/:param3]]]]',
                            'constraints' => [
                                'action' => '[a-zA-Z0-9_-]+',
                            ],
                            'defaults' => [
                                'action' => 'index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\EstadosController::class => InvokableFactory::class,
            Controller\MunicipiosController::class => InvokableFactory::class,
            Controller\EscolasController::class => InvokableFactory::class,
            Controller\PerguntasController::class => InvokableFactory::class,
            Controller\QuestionariosController::class => InvokableFactory::class,
            Controller\RespostasController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
