<?php
namespace Patient\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Patient implements InputFilterAwareInterface {
	public $id;
	public $name;
	public $gender;
	public $birth_year;
	public $condition;
	public $adherence;

	public function exchangeArray($data) {
		$this->id     		= (!empty($data['id'])) ? $data['id'] : null;
		$this->name     	= (!empty($data['name'])) ? $data['name'] : null;
		$this->gender     	= (!empty($data['gender'])) ? $data['gender'] : null;
		$this->birth_year   = (!empty($data['birth_year'])) ? $data['birth_year'] : null;
		$this->condition 	= (!empty($data['condition'])) ? $data['condition'] : null;
		$this->adherence    = (!empty($data['adherence'])) ? $data['adherence'] : null;
	}

	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception("Not used");
	}

	public function getInputFilter() {

		if (!$this->inputFilter) {

			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				'name'     => 'name',
				'required' => true,
				'filters'  => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 1,
							'max'      => 100,
						),
					),
				),
			));

			$inputFilter->add(array(
				'name'     => 'gender',
				'required' => true,
				'filters'  => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 1,
							'max'      => 100,
						),
					),
				),
			));

			$inputFilter->add(array(
				'name'     => 'birth_year',
				'required' => true,
				'filters'  => array(
					array('name' => 'Int'),
				),
			));

			$inputFilter->add(array(
				'name'     => 'condition',
				'required' => true,
				'filters'  => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 1,
							'max'      => 100,
						),
					),
				),
			));

			$inputFilter->add(array(
				'name'     => 'adherence',
				'required' => true,
				'filters'  => array(
					array('name' => 'Int'),
				),
			));

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
 }