<?php 
	namespace Album\Entity;
	
	use Doctrine\ORM\Mapping as ORM;
	
	/** @ORM\Entity */
	
	class User {
	    /**
	    * @ORM\Id
	    * @ORM\GeneratedValue(strategy="AUTO")
	    * @ORM\Column(type="integer")
	    */
	    protected $id;
	
	    /** @ORM\Column(type="string") */
	    protected $fullName;
	    
	    /**
	     * @ORM\OneToMany(targetEntity="Album\Entity\Permit", mappedBy="user")
	     * @var Collection
	     */
	    protected $permit;
	
	    public function __construct() {
	    	//Initializing collection. Doctrine recognizes Collections, not arrays!
	    	$this->permit = new ArrayCollection();
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
	    	return $this->fullName();
	    }
	    
	    /** @return Collection */
	    public function getPermit() {
	    	return $this->permit;
	    }
	     
	    /** @param Permit $permit*/
	    public function addPermit(Permit $permit) {
	    	$this->permit->add($permit);
	    	$permit->setUser($this);
	    }
	     
	    
	    
	}

?>