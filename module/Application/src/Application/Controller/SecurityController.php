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
		$reasonId = (int) $this->params()->fromRoute('id', 0);
		$redirect = $this->params()->fromRoute('redirect', '');
		$form = new LoginForm();
		if ($this->request->isPost()) {
			$form->setInputFilter(LoginFormValidator::getInputFilter());
			$form->setData($this->request->getPost());
			if ($redirect == '') {
				$data = $this->request->getPost();
				if (isset($data['redirect']))
					$redirect = $data['redirect'];
			}
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
						if (substr($redirect, 0, 4) != 'home') $redirect = 'home' . $redirect;
						$redirect = str_replace('\\', '/', $redirect);
						$qm = strpos($redirect, '?');
						if ($qm != false) {
							$redirectAction = substr($redirect, $qm + 1);
							$redirect = substr($redirect, 0, $qm);
						}
						return $this->redirect()->toRoute($redirect, array('action' => ($redirectAction ? $redirectAction : '')));
					}
			}
		}
		return new ViewModel(array(
			'form' => $form,
			'failure' => (isset ($failure) ? true : false),
			'reason' => $reasonId,
			'redirect' => ($redirect == '') ? 'home' : $redirect,
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
	 * edit access to resources
	 */
	public function resourcesAction() {
		$access = new AccessManager();
		if (!$access->checkIdentity($this->getEm(), '/security/resources')) {
			return $this->redirect()->toRoute('home/security', array('id'=>2, 'redirect'=>'\security?resources'));
		}
		
		// use query builder to find all the unique resources;
	}
	
	/**
	 * edit users roles
	 */
	public function userrolesAction() {
		$access = new AccessManager();
		if (!$access->checkIdentity($this->getEm(), '/security/userroles')) {
			return $this->redirect()->toRoute('home/security', array('id'=>2, 'redirect'=>'\security?userroles'));
		}
		$em = $this->getEm();
		$users = $em->getRepository('Application\Entity\User')->findBy(array('isDeleted' => false));
		if ($this->request->isPost()) {
			$data = $this->request->getPost();
			$nAdmin = 0;
			foreach($users as $user) {
				if ($user->getRole() != $data['setRole_'.$user->getId()]) {
					$user->setRole($data['setRole_'.$user->getId()]);
					$em->persist($user);
				}
				$nAdmin += ($user->getRole() == 'admin' ? 1 : 0);
			}
			if ($nAdmin < 1)
				$error = "Требуется хотя бы один администратор!";
			else {
				$em->flush();
				$success = "Роли успешно обновлены!";
			}
		}	
		return new ViewModel(array(
			'users' => $users,
			'error' => isset($error) ? $error : null,
			'success' => isset($success) ? $success : null,
		));
	}
	
}

?>