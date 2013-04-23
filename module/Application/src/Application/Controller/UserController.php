<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Entity\Order;
use Application\Entity\Item;
use Application\Entity\OrderItem;
use Application\Entity\User;

use Application\Form\UserForm;
use Application\Form\UserFormValidator;

class UserController extends AbstractActionController {
	
	public function getEm() {
		return $this
			->getServiceLocator()
			->get('Doctrine\ORM\EntityManager');
	}
	
	public function indexAction() {
		return $this->redirect()->toRoute('home/orders');
	}
	
	public function createUserAction() {
		$form = new UserForm();
		$user = new User();
		$form->bind ($user);
		if ($this->request->isPost()) {
			$form->setInputFilter((new UserFormValidator())->getInputFilter());
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
            	$em = $this->getEm();
				$em->persist($user);
				$em->flush();
				return $this->redirect()->toRoute('home/orders');
			}
		}
		return new ViewModel(array(
			'form' => $form,
		));
	}
	
	
	
}
?>