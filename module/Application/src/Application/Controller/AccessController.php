<?php 

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AccessController extends AbstractActionController {

	public function getEm() {
		return $this
		->getServiceLocator()
		->get('Doctrine\ORM\EntityManager');
	}
	
	
	
	
}

?>