<?php 
namespace Application\Form; 

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class LoginFormValidator {
	// Validation
	public function getInputFilter() {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
            		'name'     => 'username',
            		'required' => true,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
		                		'name' =>'NotEmpty',
		                		'options' => array(
		                			'messages' => array(
		                				\Zend\Validator\NotEmpty::IS_EMPTY => 'Логин не может быть пустым.'
		                			),
		                		),
		                	),
		                    array(
		                        'name'    => 'StringLength',
		                        'options' => array(
		                            'encoding' => 'UTF-8',
		                            'min'      => 5,
		                            'max'      => 20,
		                        	'messages' => array(
		                        		'stringLengthTooShort' => 'Пожалуйста введите строку длиной от 5 до 20 символов!',
		                        		'stringLengthTooLong' => 'Пожалуйста введите строку длиной от 5 до 20 символов!'
		                        	),
		                        ),
		                    ),
            		),
            )));
            
            $inputFilter->add($factory->createInput(array(
            		'name'     => 'password',
            		'required' => true,
            		'filters'  => array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		),
            		'validators' => array(
            				array(
            						'name' =>'NotEmpty',
            						'options' => array(
            								'messages' => array(
            										\Zend\Validator\NotEmpty::IS_EMPTY => 'Пожалуйста введите пароль.'
            								),
            						),
            				),
            				array(
		                        'name'    => 'StringLength',
		                        'options' => array(
		                            'encoding' => 'UTF-8',
		                            'min'      => 5,
		                            'max'      => 20,
		                        	'messages' => array(
		                        		'stringLengthTooShort' => 'Пожалуйста введите строку длиной от 5 до 20 символов!',
		                        		'stringLengthTooLong' => 'Пожалуйста введите строку длиной от 5 до 20 символов!'
		                        	),
		                        ),
		                    ),
            		),
            )));

        return $inputFilter;
    }
}