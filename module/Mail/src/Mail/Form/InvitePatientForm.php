<?php

namespace Mail\Form;

use Zend\Form\Form;

class InvitePatientForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('id');
		
		$this->add(array(
			'name' => 'recipient',
			'type' => 'Email',
		));
	}
}