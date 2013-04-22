<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Entity\User;

class AlbumController extends AbstractActionController {
	
	public $em;
	
	public function getEm() {
		return $this
	    	->getServiceLocator()
	    	->get('Doctrine\ORM\EntityManager');
	}
	
    public function indexAction() {
    	$em = $this->getEm();
    	
    	$user = new User();
    	$user->setFullName('Marco Pivetta');
    	
    	//$em->persist($user);
    	//$em->flush();
    }
    
    public function showAction() {
    	$em = $this->getEm();
    	$userRepo = $em->getRepository('Album\Entity\User');
    	
    	
    	$permits = $userRepo->findOneById(1)->getPermit();
    	
    	$out = array();
    	
    	foreach ($permits as $p) {
    		$out[] = $p;
    	}
    	
    	
    	return new ViewModel(array(
    		'user' => empty($out) ? null : $out,
    	));
    }

    public function addAction() {
    	
    }

    public function editAction() {
    	
    }

    public function deleteAction() {
    	
    }
}