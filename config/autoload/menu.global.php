<?php
return array(
    'navigation' => array(
        'default' => array(
            array(
                 'label' => 'Домой',
                 'route' => 'home',
             ),
        	array(
        		'label' => 'Пользователи',
        		'route' => 'home/users',
        		'pages' => array(
        			array(
        				'label' => 'Добавить пользователя',
        				'route' => 'home/users',
        				'action'=> 'createUser',
        			),
        			array(
        				'label' => 'Настроить роли',
        				'route' => 'home/security',
        				'action'=> 'userroles',
        			),
        			array(
        				'label' => 'Доступ к ресурсам',
        				'route' => 'home/security',
        				'action'=> 'resources',
        			),
        		),
        	),
        		
        		
        		
        		
        		
        		
        		
        	array(
        		'label' => 'Выход',
        		'route' => 'home/security',
        		'action'=> 'logout',
        	),
        ),
    ),
);
?>