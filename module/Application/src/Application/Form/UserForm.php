<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class UserForm extends Form {
	
    public function __construct() {
        
    	parent::__construct('user');
        
        $this->setAttribute('method', 'post');
        
        $this->setHydrator(new ClassMethodsHydrator(false));
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'fullName',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Полное имя: ',
            ),
        ));
        $this->add(array(
            'name' => 'username',
             'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Логин: ',
            ),
        ));
        $this->add(array(
        		'name' => 'password',
        		'attributes' => array(
                	'type'  => 'password',
            	),
        		'options' => array(
        			'label' => 'Пароль: ',
        		),
        ));
        $this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'role',
        		'options' => array(
        				'label' => 'Группа: ',
        				'value_options' => array(
        						'client' => 'Клиент',
        						'employee' => 'Сотрудник',
        						'finance' => 'Бухгалтер',
        						'admin' => 'Администратор',
        				),
        		)
        ));               
       $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Create User',
            	'class' => 'btn btn-primary',
                'id' => 'submitbutton',
            ),
        ));
        $this->add(array(
        		'type' => 'Zend\Form\Element\Csrf',
        		'name' => 'csrf',
        		'options' => array(
        				'csrf_options' => array(
        						'timeout' => 600
        				)
        		)
        ));
    }
}

?>