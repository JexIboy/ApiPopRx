<?php
namespace Patient\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Patient\Model\Patient;
use Patient\Form\PatientForm;
use Zend\Session\Container;

class PatientController extends AbstractActionController
{
	protected $patientTable;

	public function indexAction() {

		$patients =  $this->getPatientsTable()->fetchAll();

		return new JsonModel($patients);	
	}

	public function getPatientAction() {
		$request = $this->getRequest();

		$id = (int) $this->params()->fromRoute('id');

		if ($request->isGet()) {
			$patients =  $this->getPatientsTable()->getPatient($id);

			return new JsonModel($patients);
		}

		return new JsonModel(array(
			'status' => 'error',
			'error' => 'There is something wrong in your request'
		));
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
			} 
			
			return new JsonModel(array(
				'status' => 'error',
				'error' => 'Invalid form fields'
			));			
		}

		return new JsonModel(array(
			'status' => 'error',
			'error' => 'There is something wrong in your request'
		));
		
	}

	public function getInvitedPatientsAction() {
		$invited_patients =  $this->getPatientsTable()->getInvitedPatients();

		return new JsonModel($invited_patients);		
	}

	public function getPatientsTable() {
		if (!$this->patientTable) {
			$sm = $this->getServiceLocator();
			$this->patientTable = $sm->get('Patient\Model\PatientTable');
		}

		return $this->patientTable;
	}
}