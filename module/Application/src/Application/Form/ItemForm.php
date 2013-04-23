<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ItemForm extends Form {
	
    public function __construct() {
    	
        // we want to ignore the name passed
        parent::__construct('item');
        
        $this->setAttribute('method', 'post');
        
        $this->setHydrator(new ClassMethodsHydrator(false));
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Name: ',
            ),
        ));
        $this->add(array(
            'name' => 'count',
            'attributes' => array(
                'type'  => 'number',
            ),
            'options' => array(
                'label' => 'Count: ',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Create Item',
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
       /* $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Please verify you are human. ',
                'captcha' => array(
                    'class' => 'Dumb',
                ),
            ),
        ));*/
        
    }
}
?>