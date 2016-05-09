<?php

return array(
	'controllers' => array(
		'invokables' => array(
			'Mail\Controller\Mail' => 'Mail\Controller\MailController',
		),
	),
	'router' => array(
		'routes' => array(
			'invite_patient' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/invite-patient',
					'defaults' => array(
						'controller' => 'Mail\Controller\Mail',
						'action'     => 'invitePatient',
					),
				),
			)
		),
	)
);