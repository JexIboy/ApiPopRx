<?php
namespace Mail\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Mail;
use Mail\Form\InvitePatientForm;
use Mail\Model\InvitePatient;


class MailController extends AbstractActionController {
	
	public function invitePatientAction() {
		$request = $this->getRequest();
		$body = $request->getContent();
		$data = json_decode($body, true);

		if ($request->isPost()) {
			$patient = new InvitePatient();			
			$form = new InvitePatientForm();

			$form->setData($data);			
			$form->setInputFilter($patient->getInputFilter());
			
			if ($form->isValid()) {
				$mail = new Mail\Message();
				$mail->setBody('This is the text of the email.');
				$mail->setFrom('Freeaqingme@example.org', 'Sender\'s name');
				$mail->addTo('jex310@gmail.com', 'Name of recipient');
				$mail->setSubject('TestSubject');

				$transport = new Mail\Transport\Sendmail();

				try {
					$transport->send($mail);

					return new JsonModel(array(
						'status' => 'success'
					));
				} catch (Zend_Exception $e) {
					return new JsonModel(array(
						'status' => 'error',
						'error' => 'Unable to send email.'
					));
				}

				return new JsonModel(array(
					'status' => 'success'
				));
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
}