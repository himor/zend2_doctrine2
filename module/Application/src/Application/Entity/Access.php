<?php 
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity */
class Access {

	/** @ORM\Id()
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @var int 
	 * */
	protected $id;
	
	/** @ORM\Column(type="string", length=127) 
	 * @var string*/
	protected $resource;

	/** @ORM\Column(type="string", length=127)
	 * @var string*/
	protected $description;
	
	/** @ORM\Column(type="string", length=31)
	 * @var string*/
	protected $role;
	
	/**
	* @ORM\Column(type="integer")
	* @var int
	*/
	protected $permit;
	
	public function getResource() {
		return $this->resource;
	}
	
	public function setResource($resource) {
		$this->resource = $resource;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function setDescription($description) {
		$this->description = $description;
	}
	
	public function getRole() {
		return $this->role;
	}
	
	public function setRole($role) {
		$this->role = $role;
	}
	
	public function getPermit() {
		return $this->permit;
	}
	
	public function setPermit($permit) {
		$this->permit = $permit;
	}
	
}
?>