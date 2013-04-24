<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Entity\Order;
use Application\Entity\Item;
use Application\Entity\OrderItem;
use Application\Entity\User;

use Application\Form\ItemForm;

class OrderController extends AbstractActionController {
	
	public function getEm() {
		return $this
		->getServiceLocator()
		->get('Doctrine\ORM\EntityManager');
	}
	
	public function indexAction() {
		$em = $this->getEm();
		$orderRepo = $em->getRepository('Application\Entity\Order');
		$orders = $orderRepo -> findAll();
		return new ViewModel(array(
			'orders' => $orders
		));
	}
	
	public function createOrderAction() {
		$em = $this->getEm();
		$itemRepo = $em->getRepository('Application\Entity\Item');
		$items = $itemRepo -> findAll();
		if ($this->getRequest()->isPost()) {
			$order = new Order();
			$order -> setUser($em->getRepository('Application\Entity\User')->findOneById(1));
			$sels = $this->getRequest()->getPost('item', null);
			if (count($sels)) {
				foreach ($sels as $s) {
					$sold = $itemRepo->findOneById($s);
					$order->addItem($sold, 1);
					$sold->setCount($sold->getCount() - 1); // decrease count
					$em->persist($sold);
				}					
				$em->persist($order);
				$em->flush();
			}
			return $this->redirect()->toRoute('home/orders');
		}
		return new ViewModel(array(
			'items' => count($items) ? $items : null,
		));
	}
	
	/**
	 * axaj call
	 * @return \Zend\View\Model\ViewModel
	 */
	public function getItemsAction() {
		$id = (int) $this->params()->fromRoute('id', 0);
		$this->layout('layout/empty');
		$em = $this->getEm();
		$order = $em->getRepository('Application\Entity\Order')->findOneById($id);
		return new ViewModel(array(
			'items' => $order->getOrderItems(),
			'orderId' => $id,
		));
	}
	
	
	public function createItemAction() {
		$form = new ItemForm();
		$item = new Item();
		$form->bind ($item);
		if ($this->request->isPost()) {
			$form->setInputFilter($item->getInputFilter());
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
            	$em = $this->getEm();
				$em->persist($item);
				$em->flush();
				return $this->redirect()->toRoute('home/orders');
			}
		}
		return new ViewModel(array(
				'form' => $form,
		));
	}
	
	
	
}
?>