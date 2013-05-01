<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;

class Module {
	
	private $identity;
	
    public function onBootstrap(MvcEvent $e) {
        /*$e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);*/
    	
    }

    public function updateIdentity() {
    	$auth = new AuthenticationService();
    	if ($auth->hasIdentity()) {
    		// Identity exists; get it
    		$this->identity = $auth->getIdentity();
    	}
    }
    
    public function getConfig() {
    	$this->updateIdentity();
        $x = include __DIR__ . '/config/module.config.php';
        if (!$this->identity) {
        	// make key routes unaccessible
        	$x['router']['routes']['home']['child_routes']['cargo'] =
        		array(
	        			'type'    => 'Segment',
	        			'options' => array(
	        					'route'    => 'cargo[/][:stuff]',
	        					'constraints' => array(
	        							'stuff' => '[a-zA-Z][a-zA-Z0-9_-]*',
	        					),
	        					'defaults' => array(
	        							'controller' => 'Application\Controller\Security',
	        							'action'     => 'index',
	        					),
	        			),
	        	);
        	$x['router']['routes']['home']['child_routes']['trans'] =
        	array(
        			'type'    => 'Segment',
        			'options' => array(
        					'route'    => 'trans[/][:stuff]',
        					'constraints' => array(
        							'stuff' => '[a-zA-Z][a-zA-Z0-9_-]*',
        					),
        					'defaults' => array(
        							'controller' => 'Application\Controller\Security',
        							'action'     => 'index',
        					),
        			),
        	);
	        $x['router']['routes']['home']['child_routes']['users'] =
	        	array(
	        			'type'    => 'Segment',
	        			'options' => array(
	        					'route'    => 'users[/][:stuff]',
	        					'constraints' => array(
	        							'stuff' => '[a-zA-Z][a-zA-Z0-9_-]*',
	        					),
	        					'defaults' => array(
	        							'controller' => 'Application\Controller\Security',
	        							'action'     => 'index',
	        					),
	        			),
	        	);
        	
        }
        return $x;
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
