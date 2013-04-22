<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="linkOrderItem")
 * @ORM\HasLifecycleCallbacks()
 */
class OrderItem {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Item", inversedBy="orderItem")
     * @ORM\JoinColumn(name="itemId", referencedColumnName="id")
     * */
    protected $item;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderItem")
     * @ORM\JoinColumn(name="orderId", referencedColumnName="id")
     * */
    protected $order;
    
    /** 
     * @ORM\Column(type="integer")
     */
    protected $count;
    
    public function getId() {
    	return $this->id;
    }
    
    public function setId($id) {
    	$this->id = $id;
    }
    
    public function setItem(Item $item) {
    if($item === null || $item instanceof Item) {
			$this->item = $item;
		} else {
			throw new InvalidArgumentException('$item must be instance of Entity\Item or null!');
		}
    }
    
    public function getItem() {
    	return $this->item;
    }
    
    public function setOrder(Order $order) {
    	if($order === null || $order instanceof Order) {
    		$this->order = $order;
    	} else {
    		throw new InvalidArgumentException('$order must be instance of Entity\Order or null!');
    	}
    }
    
    public function getOrder() {
    	return $this->order;
    }

    public function getCount() {
    	return $this->count;
    }
    
    public function setCount($count) {
    	$this->count = $count;
    }


}

?>