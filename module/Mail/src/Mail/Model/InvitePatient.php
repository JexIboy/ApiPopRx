<?php
namespace Mail\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class InvitePatient implements InputFilterAwareInterface {

	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception("Not used");
	}
	
	public function getInputFilter() {

		if (!$this->inputFilter) {

			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				'name'     => 'recipient',
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
					array( 
						'name' => 'EmailAddress',
						'options' => array(
							'messages' => array(
								\Zend\Validator\EmailAddress::INVALID            => 'Invalid Email',
								\Zend\Validator\EmailAddress::INVALID_FORMAT     => 'Invalid Email',
								\Zend\Validator\EmailAddress::INVALID_HOSTNAME   => 'Invalid Email',
								\Zend\Validator\EmailAddress::INVALID_MX_RECORD  => 'Invalid Email',
								\Zend\Validator\EmailAddress::INVALID_SEGMENT    => 'Invalid Email',
								\Zend\Validator\EmailAddress::DOT_ATOM           => 'Invalid Email',
								\Zend\Validator\EmailAddress::QUOTED_STRING      => 'Invalid Email',
								\Zend\Validator\EmailAddress::INVALID_LOCAL_PART => 'Invalid Email',
								\Zend\Validator\EmailAddress::LENGTH_EXCEEDED    => 'Invalid Email'
							),
						),
						'break_chain_on_failure' => true
					)
				),
			));

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}