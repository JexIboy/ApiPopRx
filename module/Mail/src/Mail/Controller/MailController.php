<?php
namespace Mail\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail;
use Mail\Form\InvitePatientForm;
use Mail\Model\InvitePatient;


class MailController extends AbstractActionController {
	
	public function invitePatientAction() {
		$config = $this->getServiceLocator()->get('config');

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
				$mail->setFrom($data['email'], 'Sender\'s name');
				$mail->addTo('jex310@gmail.com', 'Name of recipient');
				$mail->setSubject('TestSubject');

				$transport = new SmtpTransport();
				$options   = new SmtpOptions(array(
					'name' => 'app.poprx.com',
				    'host' => 'smtp.gmail.com',
				    'port' => 465,
				    'connection_class' => 'login',
				    'connection_config' => array(
				        'username' => 'jex310@gmail.com',
				        'password' => 'motivation101',
				        'ssl'=> 'ssl'
				    ),
				));

				$transport->setOptions($options);

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