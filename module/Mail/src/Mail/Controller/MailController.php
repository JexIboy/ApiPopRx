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

				try {
					$mail = new Mail\Message();
					$mail->setBody('Please come to my clinic in your convenient time.');
					$mail->setFrom($config['email_account']['email'], $data['sender_name']);
					$mail->addTo($data['recipient']);
					$mail->setSubject('Doctor Invitation');

					$transport = new SmtpTransport();
					$options   = new SmtpOptions(array(
						'name' => 'app.poprx.com',
					    'host' => 'smtp.gmail.com',
					    'port' => 465,
					    'connection_class' => 'login',
					    'connection_config' => array(
					        'username' => $config['email_account']['email'],
					        'password' => $config['email_account']['password'],
					        'ssl'=> 'ssl'
					    ),
					));

					$transport->setOptions($options);

				
					$transport->send($mail);

					return new JsonModel(array(
						'status' => 'success'
					));
				} catch (Zend_Exception $e) {
					return new JsonModel(array(
						'status' => 'error',
						'error' => 'Unable to send email. Please try again.'
					));
				}

				return new JsonModel(array(
					'status' => 'success'
				));
			} else {
				var_dump($form->getMessages());
				return new JsonModel(array(
					'status' => 'error',
					'error' => 'Invalid form fields'
				));
			}
		}

		return new JsonModel(array(
			'status' => 'error',
			'error' => 'There is something wrong in your request'
		));
	}
}