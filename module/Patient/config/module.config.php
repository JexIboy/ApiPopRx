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
			'invited_patients' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/invited-patients',
					'defaults' => array(
						'controller' => 'Patient\Controller\Patient',
						'action'     => 'getInvitedPatients',
					),
				),
			),
			'view_patient' => array(
				'type'    => 'Segment',
				'options' => array(
					'route'    => '/patient[/:id]',
					'constraints' => array(
						'id' => '[0-9]+',
					),
					'defaults' => array(
						'controller' => 'Patient\Controller\Patient',
						'action'     => 'getPatient',
					),
				),
			),
		),
	)
);