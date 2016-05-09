<?php
namespace Patient;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Patient\Model\Patient;
use Patient\Model\PatientTable;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface {
	
	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php',
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

	public function getConfig()	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getServiceConfig(){
		return array(
			'factories' => array(
				'Patient\Model\PatientTable' =>  function($sm) {
					$tableGateway = $sm->get('PatientTableGateway');
					$table = new PatientTable($tableGateway);
					
					return $table;
				},
				'PatientTableGateway' => function ($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Patient());

					return new TableGateway('patients', $dbAdapter, null, $resultSetPrototype);
				},
			),
		);
	}
}