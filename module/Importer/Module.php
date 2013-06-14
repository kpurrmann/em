<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Importer;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements \Zend\ModuleManager\Feature\BootstrapListenerInterface, \Zend\ModuleManager\Feature\ConfigProviderInterface, \Zend\ModuleManager\Feature\AutoloaderProviderInterface
{

    public function onBootstrap(\Zend\EventManager\EventInterface $e)
    {
        $this->serviceLocator = $e->getApplication()->getServiceManager();
        /* @var $sharedEventManager \Zend\EventManager\SharedEventManager */
        $sharedEventManager = $this->serviceLocator->get('SharedEventManager');
        $sharedEventManager->attach('Importer\Service\ImportService', 'set-import-form', array($this, 'onFormSet'));
    }

    /**
     * Set up Import Form
     *
     * @param \Zend\EventManager\EventInterface $e
     */
    public function onFormSet(\Zend\EventManager\EventInterface $e)
    {
        $service = $this->serviceLocator->get('Importer\Service\Import');
        $form = $this->serviceLocator->get('Importer\Form\Import');
        $service->setForm($form);
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

}
