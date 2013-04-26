<?php

namespace Application\Security;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result as AuthResult;
use Application\Entity\User;
use Zend\Crypt\Password\Bcrypt;

class SecurityAdapter implements AdapterInterface {
	
	private $username;
	private $password;
	private $em;
	
	/**
	 * Sets username and password for authentication
	 *
	 * @return void
	 */
	public function __construct($username, $password, $em = null) {
		$this->username = $username;
		$this->password = $password;
		if (null != $em)
			$this->setEm($em);
	}

	public function setEm($em) {
		$this->em = $em;
	}
	
	/**
	 * Performs an authentication attempt
	 *
	 * @return \Zend\Authentication\Result
	 * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface
	 *               If authentication cannot be performed
	 */
	public function authenticate() {
		$identity = array('username' => $this->username,
				'role' => null);
		$em = $this->em;
		$userRepo = $em->getRepository('Application\Entity\User');
		$user = $userRepo->findOneBy(array('username' => $this->username));
		if (!$user) {
			return new AuthResult(AuthResult::FAILURE, $identity);
		}
		$bcrypt = new Bcrypt();
		if ($bcrypt->verify($this->password, $user->getPassword())) {
			$identity = array('username' => $user->getUsername(),
							  'role' => $user->getRole());
			return new AuthResult(AuthResult::SUCCESS, $identity);
		} else 
			return new AuthResult(AuthResult::FAILURE, $identity);
	}
}