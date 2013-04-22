<?php 
	namespace Application\Entity;
	
	use Doctrine\ORM\Mapping as ORM;
	use Doctrine\Common\Collections\ArrayCollection;
	
	/** @ORM\Entity */
	
	class User {
	    /**
	    * @ORM\Id
	    * @ORM\GeneratedValue(strategy="AUTO")
	    * @ORM\Column(type="integer")
	    */
	    protected $id;
	
	    /** @ORM\Column(type="string", length=50) */
	    protected $fullName;
	    
	    /** @ORM\Column(type="string", length=20) */
	    protected $username;
	    
	    /** @ORM\Column(type="string", length=50) */
	    protected $password;
	    
	    /**
	     * @ORM\OneToMany(targetEntity="Application\Entity\Order", mappedBy="user")
	     * @var Collection
	     */
	    protected $orders;
	
	    public function __construct() {
	    	//Initializing collection. Doctrine recognizes Collections, not arrays!
	    	$this->orders = new ArrayCollection();
	    }
	    
	    public function setId($id) {
	    	$this->id = $id;
	    }
	    
	    public function getId() {
	    	return $this->id;
	    }
	    
	    public function setFullName($fullName) {
	    	$this->fullName = $fullName;
	    }
	     
	    public function getFullName() {
	    	return $this->fullName;
	    }
	    
	    public function setUsername($username) {
	    	$this->username = $username;
	    }
	    
	    public function getUsername() {
	    	return $this->username;
	    }
	    
	    public function setPassword($password) {
	    	$this->password = $password;
	    }
	    
	    public function getPassword() {
	    	return $this->password;
	    }
	    
	    public function getOrders() {
	    	return $this->orders;
	    }
	     
	    public function addOrder(Order $order) {
	    	$this->order->add($order);
	    	$order->setUser($this);
	    }
	     
	    
	    
	}

?>