<?php 
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity */
class Item {

	/** @ORM\Id()
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @var int 
	 * */
	protected $id;
	
	/** @ORM\Column(type="string", length=50) 
	 * @var string*/
	protected $name;
	 
	/**
	* @ORM\Column(type="integer")
	* @var int
	*/
	protected $count;
	
	/**
	 * @ORM\OneToMany(targetEntity="OrderItem" , mappedBy="item" , cascade={"all"})
	 * @var OrderItem
	 * */
	protected $orderItem;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	public function getCount() {
		return $this->count;
	}
	
	public function setCount($count) {
		$this->count = $count;
		return $this;
	}
	
}