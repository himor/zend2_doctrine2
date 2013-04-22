<?php 
namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */

class Permit {
	
	/** @ORM\Id()  
	 * @ORM\Column(type="integer") 
	 * @ORM\GeneratedValue(strategy="AUTO") 
	 * @var int */
	private $id;

	/** @ORM\Column(type="string", length=255) 
	 * @var string */
	private $content;

	/**
	 * @ORM\ManyToOne(targetEntity="Album\Entity\User", inversedBy="permit")
	 * @var User|null
	 */
	private $user;

	public function __construct($content) {
		$this->setContent($content);
	}

	//Setters, getters

	/** @return User|null */
	public function getUser() {
		return $this->user;
	}

	/** @param User $user */
	public function setUser(User $user) {
		if($user === null || $user instanceof User) {
			$this->user = $user;
		} else {
			throw new InvalidArgumentException('$user must be instance of Entity\User or null!');
		}
	}
	
	public function getContent() {
		return $this->content;
	}

}

?>