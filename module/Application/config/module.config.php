<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

$config =  array(
	'doctrine' => array(
		'driver' => array(
			'application_entities' => array(
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/Application/Entity')
			),
			'orm_default' => array(
				'drivers' => array(
					'Application\Entity' => 'application_entities'
				)
		))),
		
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            //),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
           /* 'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),*/
                'may_terminate' => true,
                'child_routes' => array(
                    /*'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),*/
                    'cargo' => array(
	                    'type'    => 'Segment',
	                    'options' => array(
	                    	'route'    => 'cargo[/][:action][/:id]',
			                   'constraints' => array(
			                       'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
			                       'id'     => '[0-9]+',
			                   ),
			                   'defaults' => array(
			                       'controller' => 'Application\Controller\Cargo',
			                       'action'     => 'index',
                    		),
	                    ),
                    ),
                    'trans' => array(
                    		'type'    => 'Segment',
                    		'options' => array(
                    				'route'    => 'trans[/][:action][/:id]',
                    				'constraints' => array(
                    						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    						'id'     => '[0-9]+',
                    				),
                    				'defaults' => array(
                    						'controller' => 'Application\Controller\Trans',
                    						'action'     => 'index',
                    				),
                    		),
                    ),
                    'users' => array(
                    		'type'    => 'Segment',
                    		'options' => array(
                    				'route'    => 'users[/][:action][/:id]',
                    				'constraints' => array(
                    						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    						'id'     => '[0-9]+',
                    				),
                    				'defaults' => array(
                    						'controller' => 'Application\Controller\User',
                    						'action'     => 'index',
                    				),
                    		),
                    ),
                    'security' => array(
                    		'type'    => 'Segment',
                    		'options' => array(
                    				'route'    => 'security[/][:action][/:id][/:redirect]',
                    				'constraints' => array(
                    						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    						'id'     => '[0-9]+',
                    				),
                    				'defaults' => array(
                    						'controller' => 'Application\Controller\Security',
                    						'action'     => 'index',
                    				),
                    		),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' 		=> 'Application\Controller\IndexController',
            'Application\Controller\Cargo' 		=> 'Application\Controller\CargoController',
            'Application\Controller\Trans' 		=> 'Application\Controller\TransController',
            'Application\Controller\User'		=> 'Application\Controller\UserController',
            'Application\Controller\Security' 	=> 'Application\Controller\SecurityController',
            'Application\Controller\Access' 	=> 'Application\Controller\AccessController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/empty'         	  => __DIR__ . '/../view/layout/empty.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);

return $config;
