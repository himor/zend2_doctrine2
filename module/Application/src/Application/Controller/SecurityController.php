<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Entity\User;

use Application\Form\LoginForm;
use Application\Form\LoginFormValidator;
use Application\Security\SecurityAdapter;
use Application\Security\AccessManager;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

class SecurityController extends AbstractActionController {
	
	public function getEm() {
		return $this
			->getServiceLocator()
			->get('Doctrine\ORM\EntityManager');
	}
	
	/**
	 * Login action /security
	 */
	public function indexAction() {
		$form = new LoginForm();
		if ($this->request->isPost()) {
			$form->setInputFilter(LoginFormValidator::getInputFilter());
			$form->setData($this->request->getPost());
			if ($form->isValid()) {
				$data = $form->getData();
				$username = $data['username'];
				$password = $data['password'];
				$adapter = new SecurityAdapter($username, $password, $this->getEm());
				$authService = new AuthenticationService();
				$result = $authService->authenticate($adapter);
				if (!$result->isValid()) {
					// Authentication failed; print the reasons why
						$failure = 1;
					} else {
						// success
						return $this->redirect()->toRoute('home/orders');
					}
			}
		}
		return new ViewModel(array(
			'form' => $form,
			'failure' => (isset ($failure) ? true : false),
		));
	}
	
	/**
	 * Logout action /security/logout
	 */
	public function logoutAction() {
		$authService = new AuthenticationService();
		$authService->clearIdentity();
		return $this->redirect()->toRoute('home/security');
	}
	
	/**
	 * test action
	 */
	public function viewAction() {
		$access = new AccessManager();
		if (!$access->checkIdentity($this->getEm(), '/security/userroles')) {
			return $this->redirect()->toRoute('home/security');
		}
		return $this->redirect()->toRoute('home/orders');		
	}
	
}

?>