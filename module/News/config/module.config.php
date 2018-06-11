<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace News;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'news' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '[/:controller][/:action][/:page]',
                    'defaults' => [
                        // 'controller'=>Controller\NewsController::class,
                        // 'action'    =>'add',
                    ],
                    'constraints'=>[
                        'page'=>'[0-9]+'
                    ]
                    
                ],
            ],
            
        ],
    ],
    'controllers' => [
        'factories' => [
            //Controller\NewsController::class => InvokableFactory::class,
             //Controller\HomeController::class => InvokableFactory::class
        ],
        'aliases'=>[
            'news'=>Controller\NewsController::class,
            //'home'=>Controller\HomeController::class
        ]
    ],
   'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
