<?php
namespace Application\Form;

use Zend\Form\Form;

class LoginForm extends Form {
	
    public function __construct() {
        
    	parent::__construct('login');
        
        $this->setAttribute('method', 'post');
        
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
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Войти',
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