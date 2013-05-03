<?php 
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity */
class Route {

	/** @ORM\Id()
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @var int 
	 * */
	protected $id;
	
	/** @ORM\Column(type="string", length=511)
	 * @var string*/
	protected $description;
	
	/** @ORM\Column(type="boolean") */
	protected $isDeleted;
	
	function __construct() {
		$this->setDeleted(false);
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function setDescription($description) {
		$this->description = $description;
	}
	
	public function getDeleted() {
		return $this->isDeleted;
	}
	
	public function setDeleted($isDeleted) {
		$this->isDeleted = $isDeleted;
	}
	
	public function getDescriptionNormal($crop = true) {
		$d = explode('|',$this->description);
		if (count($d) > 3 && $crop) {
			$d = array($d[0], $d[1], '...', $d[count($d)-1]);
		}
		return implode(' - ', $d);
	}
	
}
?>