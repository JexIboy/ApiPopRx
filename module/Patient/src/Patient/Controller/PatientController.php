<?php
namespace Patient\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Patient\Model\Patient;
use Patient\Form\PatientForm;

class PatientController extends AbstractActionController
{
	protected $patientTable;

	public function indexAction() {
		$patients =  $this->getPatientsTable()->fetchAll();

		return new JsonModel($patients);
	}

	public function addAction() {
		$request = $this->getRequest();
		$body = $request->getContent();
		$data = json_decode($body, true);

		if ($request->isPost()) {

			$patient = new Patient();
			
			$form = new PatientForm();

			$form->setData($data);			
			$form->setInputFilter($patient->getInputFilter());
			
			if ($form->isValid()) {

				$patient->exchangeArray($form->getData());

				$result = $this->getPatientsTable()->savePatient($patient);

				return new JsonModel($result);
			} else {
				return new JsonModel(array(
					'status' => 'error',
					'error' => 'Invalid form fields'
				));
			}
		} else {
			return new JsonModel(array(
				'status' => 'error',
				'error' => 'There is something wrong in your request'
			));
		}
	}

	public function editAction() {

	}

	public function deleteAction() {

	}

	public function getPatientsTable() {
		if (!$this->patientTable) {
			$sm = $this->getServiceLocator();
			$this->patientTable = $sm->get('Patient\Model\PatientTable');
		}

		return $this->patientTable;
	}
}