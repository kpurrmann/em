<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Event;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements \Zend\ModuleManager\Feature\BootstrapListenerInterface, \Zend\ModuleManager\Feature\ConfigProviderInterface, \Zend\ModuleManager\Feature\AutoloaderProviderInterface
{

    /**
     *
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceLocator = null;

    public function onBootstrap(\Zend\EventManager\EventInterface $e)
    {
        $this->serviceLocator = $e->getApplication()->getServiceManager();
        /* @var $sharedEventManager \Zend\EventManager\SharedEventManager */
        $sharedEventManager = $this->serviceLocator->get('SharedEventManager');
        $sharedEventManager->attach('Event\Service\EventService', 'set-event-form', array($this, 'onFormSet'));
    }

    public function onFormSet(\Zend\EventManager\EventInterface $e)
    {
        $type = $e->getParam('type', 'default');
        $service = $this->serviceLocator->get('Event\Service\Event');
        $form = $this->serviceLocator->get('Event\Form\Event');
        $service->setForm($form, $type);
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
