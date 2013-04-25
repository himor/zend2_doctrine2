<?php

/**
 * AccessManager 
 * @author Mike Gordo mgordo@live.com
 */

namespace Application\Security;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Doctrine\ORM\EntityManager;
use Application\Entity\Access;

class AccessManager {
		
	private $acl;
	
	const YES = 1;
	const NO  = 0;

	/**
	 * Building the resource table from the database
	 */
	function __construct(EntityManager $em = null) {
		$acl = new Acl();
		
		$acl->addRole(new Role('admin'))
			->addRole(new Role('employee'))
			->addRole(new Role('finance'))
			->addRole(new Role('client'));
		
		$accessRepo = $em->getRepository('Application\Entity\Access');
		$access = $accessRepo->findAdd();
		
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
	 * Checks if user can access the resource
	 */
	function isAllowed($identity_role, $resource) {
		return $this->acl->isAllowed($identity_role, $resource);
	}
	
}

?>