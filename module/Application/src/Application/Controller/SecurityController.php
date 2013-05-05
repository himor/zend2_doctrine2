<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Application\Entity\User;
use Application\Entity\Access;

use Application\Form\LoginForm;
use Application\Form\LoginFormValidator;
use Application\Security\SecurityAdapter;
use Application\Security\AccessManager;

class SecurityController extends AbstractActionController {
	
	public function getEm() {
		return $this
			->getServiceLocator()
			->get('Doctrine\ORM\EntityManager');
	}
	
	/**
	 * ============================================================================
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
	 * ============================================================================
	 * Logout action /security/logout
	 */
	public function logoutAction() {
		$authService = new AuthenticationService();
		$authService->clearIdentity();
		return $this->redirect()->toRoute('home/security');
	}
	
	/**
	 * ============================================================================
	 * edit access to resources
	 */
	public function resourcesAction() {
		$access = new AccessManager();
		if (!$access->checkIdentity($this->getEm(), '/security/resources')) {
			return $this->redirect()->toRoute('home/security', array('id'=>2, 'redirect'=>'\security?resources'));
		}
		$em = $this->getEm();
		$temp = $em->getRepository('Application\Entity\Access')->findAll();
		$source = array();
		$proc = array();
		
		if ($this->request->isPost()) {
			$data = $this->request->getPost();
			foreach($temp as $t) {
				$t->setPermit($data[$t->getRole()."_".md5($t->getResource())]);
				$em->persist($t);				
			}
			$em->flush();
			$success = "Ресурсы успешно обновлены!";
		}
		
		foreach ($temp as $t) {
			if (!in_array($t->getResource(), $proc)) {
				$proc[] = $t->getResource();
				$s = array(
						'resource' => $t->getResource(),
						'description' => $t->getDescription(),
						'id' => md5($t->getResource()),
				);
				$s[$t->getRole()] = $t->getPermit();
				$source[$t->getResource()] = $s;
			} else {
				$source[$t->getResource()][$t->getRole()] = $t->getPermit();
			}
		}
		
		return new ViewModel(array(
				'source' => $source,
				'error' => isset($error) ? $error : null,
				'success' => isset($success) ? $success : null,
		));
	}
	
	/**
	 * ============================================================================
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
	
	/**
	 * TODO DELETE FROM PRODUCTION
	 */
	public function installUserAction() {
		$em = $this->getEm();
 		$bcrypt = new Bcrypt();
 		$securePass = $bcrypt->create('admin');
 		$user = new User();
 		$user->setPassword($securePass);
 		$user->setUsername('admin');
 		$user->setFullName('Admin');
 		$user->setRole('admin');
 		$em->persist($user);
		
		$res = array('/cargo','/cargo/paths','/cargo/createPath','/cargo/editPath','/users/createUser');
		
		foreach ($res as $r) {
			$access = new Access();
			$access->setResource($r);
			$access->setPermit(1);
			$access->setDescription('');
			$access->setRole('admin');
			$em->persist($access);
			$access = new Access();
			$access->setResource($r);
			$access->setPermit(0);
			$access->setDescription('');
			$access->setRole('employee');
			$em->persist($access);
			$access = new Access();
			$access->setResource($r);
			$access->setPermit(0);
			$access->setDescription('');
			$access->setRole('client');
			$em->persist($access);
			$access = new Access();
			$access->setResource($r);
			$access->setPermit(0);
			$access->setDescription('');
			$access->setRole('finance');
			$em->persist($access);
		}
		
		$em->flush();
		die('done');
	}
	
	/**
	 * ============================================================================
	 * create new resource
	 */
	public function newResourceAction() {
		$em = $this->getEm();
		$data = $this->request->getPost();
		$a = new Access();
		$a->setResource($data['rname']);
		$a->setDescription($data['desc']);
		$a->setRole('admin');
		$a->setPermit('1');
		$em->persist($a);
		
		$a = new Access();
		$a->setResource($data['rname']);
		$a->setDescription($data['desc']);
		$a->setRole('finance');
		$a->setPermit('0');
		$em->persist($a);
		
		$a = new Access();
		$a->setResource($data['rname']);
		$a->setDescription($data['desc']);
		$a->setRole('employee');
		$a->setPermit('0');
		$em->persist($a);
		
		$a = new Access();
		$a->setResource($data['rname']);
		$a->setDescription($data['desc']);
		$a->setRole('client');
		$a->setPermit('0');
		$em->persist($a);
		
		$em->flush();
		return "ok";
	}
}

?>