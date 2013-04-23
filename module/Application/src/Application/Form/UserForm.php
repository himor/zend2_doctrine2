<?php
namespace Application\Form;

use Zend\Form\Form;

class UserForm extends Form {
	
    public function __construct() {
        
    	parent::__construct('createUser');
        
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'fullName',
            'type' => 'Text',
            'options' => array(
                'label' => 'Enter full name:',
            ),
        ));
        $this->add(array(
            'name' => 'username',
            'type' => 'Text',
            'options' => array(
                'label' => 'Enter username:',
            ),
        ));
        $this->add(array(
        		'name' => 'password',
        		'type' => 'Text',
        		'options' => array(
        				'label' => 'Enter password:',
        		),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}