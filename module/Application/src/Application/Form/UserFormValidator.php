<?php 
namespace Application\Form; 

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
//use Zend\Validator\NotEmpty;

class UserFormValidator {
	// Validation
	public function getInputFilter() {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'fullName',
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
                				\Zend\Validator\NotEmpty::IS_EMPTY => 'Имя пользователя не может быть пустым.'
                			),
                		),
                	),
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                            'max'      => 50,
                        	'messages' => array(
                        		'stringLengthTooShort' => 'Пожалуйста введите строку длиной от 5 до 50 символов!',
                        		'stringLengthTooLong' => 'Пожалуйста введите строку длиной от 5 до 50 символов!'
                        	),
                        ),
                    ),
                ),
            )));
            
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
		                				\Zend\Validator\NotEmpty::IS_EMPTY => 'Пароль не может быть пустым.'
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