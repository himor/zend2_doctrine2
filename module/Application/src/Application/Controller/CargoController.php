<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

use Application\Entity\Order;
use Application\Entity\Item;
use Application\Entity\OrderItem;
use Application\Entity\User;
use Application\Entity\Route;
use Application\Entity\RouteCity;

use Application\Form\ItemForm;
use Application\Form\ItemFormValidator;

use Application\Security\AccessManager;

class CargoController extends AbstractActionController {
	
	public function getEm() {
		return $this
			->getServiceLocator()
			->get('Doctrine\ORM\EntityManager');
	}
	
	public function indexAction() {
		$access = new AccessManager();
		if (!$access->checkIdentity($this->getEm(), '/cargo')) {
			return $this->redirect()->toRoute('home/security', array('id'=>2, 'redirect'=>'\cargo'));
		}
		
		$auth = new AuthenticationService();
		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
			$role = $identity['role'];
		}
		
		return new ViewModel(array(
			'role' => isset($role) ? $role : null,
			'permits' => $access->getMyRules(),
		));
	}
	
	public function pathsAction() {
		$access = new AccessManager();
		if (!$access->checkIdentity($this->getEm(), '/cargo/paths')) {
			return $this->redirect()->toRoute('home/security', array('id'=>2, 'redirect'=>'\cargo?paths'));
		}
		$em = $this->getEm();
		$routes = $em->getRepository('Application\Entity\Route')->findBy(array('isDeleted' => false));
		return new ViewModel(array(
			'routes' => $routes
		));
	}
	
	public function createPathAction() {
		$access = new AccessManager();
		if (!$access->checkIdentity($this->getEm(), '/cargo/createPath')) {
			return $this->redirect()->toRoute('home/security', array('id'=>2, 'redirect'=>'\cargo?createPath'));
		}
		$em = $this->getEm();
		$cities = $em->getRepository('Application\Entity\RouteCity')->findAll();
		usort($cities, function($a,$b){
			return ($a->getDescription() > $b->getDescription() ? 1:-1);
		});
		if ($this->request->isPost()) {
			$data = $this->request->getPost();
			if (strlen($data['description']) > 0) {
				$path = new Route();
				$path->setDescription($data['description']);
				$em->persist($path);
				$em->flush();				
				return $this->redirect()->toRoute('home/cargo', array('action'=>'paths'));
			}
			$error = "Ошибка создания маршрута.";
		}
		return new ViewModel(array(
			'cities' => $cities,
			'error' => isset($error) ? $error : null,
			'success' => isset($success) ? $success : null,
		));
	}
	
	public function updatePathAction() {
		$access = new AccessManager();
		if (!$access->checkIdentity($this->getEm(), '/cargo/editPath')) {
			return $this->redirect()->toRoute('home/security', array('id'=>2, 'redirect'=>'\cargo?paths'));
		}
		$id = (int) $this->params()->fromRoute('id', 0);
		$em = $this->getEm();
		$route = $em->getRepository('Application\Entity\Route')->findOneById($id);
		if (!$route) return $this->redirect()->toRoute('home/cargo', array('action'=>'paths'));
		$routeCities = explode('|', $route->getDescription());
		$cities = $em->getRepository('Application\Entity\RouteCity')->findAll();
		usort($cities, function($a,$b){
			return ($a->getDescription() > $b->getDescription() ? 1:-1);
		});
		if ($this->request->isPost()) {
			$data = $this->request->getPost();
			if (strlen($data['description']) > 0) {
				$route->setDescription($data['description']);
				$em->persist($route);
				$em->flush();				
				return $this->redirect()->toRoute('home/cargo', array('action'=>'paths'));
			}
			$error = "Ошибка создания маршрута.";
		}		
		return new ViewModel(array(
				'route' => $route,
				'routeCities' => $routeCities,
				'cities' => $cities,
				'error' => isset($error) ? $error : null,
				'success' => isset($success) ? $success : null,
		));
	}
	
	public function deletePathAction() {
		$access = new AccessManager();
		if (!$access->checkIdentity($this->getEm(), '/cargo/editPath')) {
			return $this->redirect()->toRoute('home/security', array('id'=>2, 'redirect'=>'\cargo?paths'));
		}
		$id = (int) $this->params()->fromRoute('id', 0);
		$em = $this->getEm();
		$route = $em->getRepository('Application\Entity\Route')->findOneById($id);
		if ($route) {
			$route->setDeleted(true);
			$em->persist($route);
			$em->flush();
		}
		return $this->redirect()->toRoute('home/cargo', array('action'=>'paths'));
	}
	
	/*public function createOrderAction() {
		
		// no security
		
		$em = $this->getEm();
		$itemRepo = $em->getRepository('Application\Entity\Item');
		$items = $itemRepo -> findAll();
		if ($this->getRequest()->isPost()) {
			$order = new Order();
			$order -> setUser($em->getRepository('Application\Entity\User')->findOneById(1));
			$sels = $this->getRequest()->getPost('item', null);
			if (count($sels)) {
				foreach ($sels as $s) {
					$itemCount = $this->getRequest()->getPost('itemCount_'.$s, 1);
					$sold = $itemRepo->findOneById($s);
					$order->addItem($sold, $itemCount);
					$sold->setCount($sold->getCount() - $itemCount); // decrease count
					$em->persist($sold);
				}					
				$em->persist($order);
				$em->flush();
			}
			return $this->redirect()->toRoute('home/cargo');
		}
		return new ViewModel(array(
			'items' => count($items) ? $items : null,
		));
	}*/
	
	/**
	 * ajax call
	 */
	public function getPathContentAction() {
		// no need securtiy
		$id = (int) $this->params()->fromRoute('id', 0);
		$this->layout('layout/empty');
		$em = $this->getEm();
		// find the route, decompose it and return table
		$routeN = $em->getRepository('Application\Entity\Route')->findOneById($id);
		$desc = $routeN->getDescription(); // One|Two|Thr-ee|Four
		$cities = explode('|', $desc); 
		return new ViewModel(array(
			'cities' => $cities,
			'route' => $routeN,
		));
	}
	
	/**
	 * ajax call
	 */
	public function createCityAction() {
		// no need securtiy
		$this->layout('layout/empty');
		$em = $this->getEm();
		$rc = new RouteCity();
		$data = $this->request->getPost();
		$rc->setDescription($data['cname']);
		$em->persist($rc);
		$em->flush();
		return "ok";
	}
	
}
?>
