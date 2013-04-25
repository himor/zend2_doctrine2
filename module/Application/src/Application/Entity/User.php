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
	
	    /** @ORM\Column(type="string", length=127) */
	    protected $fullName;
	    
	    /** @ORM\Column(type="string", length=63) */
	    protected $username;
	    
	    /** @ORM\Column(type="string", length=127) */
	    protected $password;
	    
	    /** @ORM\Column(type="string", length=31) */
	    protected $role;
	    
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
	    
	    public function getRole() {
	    	return $this->role;
	    }
	    
	    public function setRole($role) {
	    	$this->role = $role;
	    }
	    
	    
	}

?>