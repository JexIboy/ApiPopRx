<?php

return array(
	'controllers' => array(
		'invokables' => array(
			'Patient\Controller\Patient' => 'Patient\Controller\PatientController',
		),
	),
	'router' => array(
		'routes' => array(
			'patients' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/patients',
					'defaults' => array(
						'controller' => 'Patient\Controller\Patient',
						'action'     => 'index',
					),
				),
			),
			'add_patient' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/add/patient',
					'defaults' => array(
						'controller' => 'Patient\Controller\Patient',
						'action'     => 'add',
					),
				),
			),
		),
	)
);