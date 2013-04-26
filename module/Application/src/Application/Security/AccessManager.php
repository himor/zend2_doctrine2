<?php

/**
 * AccessManager 
 * @author Mike Gordo mgordo@live.com 
 * Apr 25, 2013
 */

namespace Application\Security;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\Authentication\AuthenticationService;

use Doctrine\ORM\EntityManager;
use Application\Entity\Access;

class AccessManager {
		
	private $acl;
	private $em;
	
	const YES = 1;
	const NO  = 0;

	/**
	 * Building the resource table from the database
	 */
	public function initializeAccess() {
		$acl = new Acl();
		
		$acl->addRole(new Role('admin'))
			->addRole(new Role('employee'))
			->addRole(new Role('finance'))
			->addRole(new Role('client'));
		
		// define main security list
		$acl->addResource(new Resource('/security/resources'));
		$acl->addResource(new Resource('/security/userroles'));
		$acl->allow('admin', '/security/resources');
		$acl->allow('admin', '/security/userroles');
		// EOF define main security list
		
		$accessRepo = $this->em->getRepository('Application\Entity\Access');
		$access = $accessRepo->findAll();
		
		foreach ($access as $a) {
			$newRes = new Resource($a->getResource());
			if (!$acl->hasResource($newRes))
				$acl->addResource($newRes);
			if ($a->getPermit() == AccessManager::YES)
				$acl->allow($a->getRole(), $a->getResource());
			if ($a->getPermit() == AccessManager::NO)
				$acl->deny($a->getRole(), $a->getResource());
		}
		
		$this->acl = $acl;
	}

	/**
	 * Overloader
	 */
	public function checkIdentity($em, $resource) {
		$this->em = $em;
		$this->initializeAccess();
		$auth = new AuthenticationService();
		if ($auth->hasIdentity()) {
			// Identity exists; get it
			$identity = $auth->getIdentity();
			return $this->acl->isAllowed($identity['role'], $resource);
		} else
			return false;
	}
	
}

?>