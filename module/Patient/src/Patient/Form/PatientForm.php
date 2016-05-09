<?php

namespace Patient\Form;

use Zend\Form\Form;

class PatientForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('id');

		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));

		$this->add(array(
			'name' => 'name',
			'type' => 'Text'
		));

		$this->add(array(
			'name' => 'gender',
			'type' => 'Text'
		));

		$this->add(array(
			'name' => 'gender',
			'type' => 'Text'
		));

		$this->add(array(
			'name' => 'birth_year',
			'type' => 'Text'
		));

		$this->add(array(
			'name' => 'adherence',
			'type' => 'Text'
		));
	}
}