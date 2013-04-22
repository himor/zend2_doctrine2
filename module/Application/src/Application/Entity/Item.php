<?php 
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity */

class Item {

	/** @ORM\Id() 
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @var int */
	private $id;

	/** @ORM\Column(type="string", length=50) */
	private $name;
	 
	/**
	* @ORM\Column(type="integer")
	*/
	private $count;
	
	/**
	 * @ORM\OneToMany(targetEntity="OrderItem" , mappedBy="item" , cascade={"all"})
	 * */
	protected $orderItem;
	

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getCount() {
		return $this->count;
	}
	
	public function setCount($count) {
		$this->count = $count;
	}


}

?>