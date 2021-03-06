<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Zend\Session\Config\SessionConfig;

class Module
{
	public function onBootstrap(MvcEvent $e)
	{
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);

	 	$sessionConfig = new SessionConfig();
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

	public function getServiceConfig()
	{
		return array(
			'factories' => array(
				'Zend\Session\SessionManager' => function ($sm) {
					$config = $sm->get('config');
					if (isset($config['session'])) {
						$session = $config['session'];

						$sessionConfig = null;
						if (isset($session['config'])) {
							$class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
							$options = isset($session['config']['options']) ? $session['config']['options'] : array();
							$sessionConfig = new $class();
							$sessionConfig->setOptions($options);
						}

						$sessionStorage = null;
						if (isset($session['storage'])) {
							$class = $session['storage'];
							$sessionStorage = new $class();
						}

						$sessionSaveHandler = null;
						if (isset($session['save_handler'])) {
							// class should be fetched from service manager since it will require constructor arguments
							$sessionSaveHandler = $sm->get($session['save_handler']);
						}

						$sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);
					} else {
						$sessionManager = new SessionManager();
					}
					Container::setDefaultManager($sessionManager);
					return $sessionManager;
				},
			),
		);
	}
}
