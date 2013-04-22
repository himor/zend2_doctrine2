<?php 
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity 
* 	@ORM\Table(name="Orders")
*/

class Order {
	
	/** @ORM\Id()  
	 * @ORM\Column(type="integer") 
	 * @ORM\GeneratedValue(strategy="AUTO") 
	 * @var int */
	private $id;

	/**
	 * @ORM\OneToMany(targetEntity="Application\Entity\OrderItem", mappedBy="order", cascade={"all"})
	 * */
	private $orderItems;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Application\Entity\User", inversedBy="order")
	 * @var User|null
	 */
	private $user;

	public function __construct() {
		$this->orderItems = new ArrayCollection();
	}

	public function getId() {
		return $this->id;
	}
	
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
		
	public function getItems() {
		$items = new ArrayCollection();
		foreach($this->orderItems as $p) {
			$items[] = $p->getItem();
		}
		return $items;
	}
	
	public function addItem($item, $count = 1) {
		$po = new OrderItem();
		$po->setOrder($this);
		$po->setItem($item);
		$po->setCount($count);
		$this->addOrderItem($po);
	}
	
	public function addOrderItem($OrderItem) {
		$this->orderItems[] = $OrderItem;
	}
	
	public function removeOrderItem($OrderItem) {
		return $this->orderItems->removeElement($OrderItem);
	}
	
	public function getOrderItems() {
		return $this->orderItems;
	}
	
}

?>