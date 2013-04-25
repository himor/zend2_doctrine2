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
                'label' => 'User name:',
            ),
        ));
        $this->add(array(
        		'name' => 'password',
        		'attributes' => array(
                	'type'  => 'password',
            	),
        		'options' => array(
        			'label' => 'Enter password:',
        		),
        ));
       $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Login',
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