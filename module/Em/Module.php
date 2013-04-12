<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Em;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('dispatch', array($this, 'setLayout'));
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Methods sets Controller specific layout
     * 
     * @param string $layout
     */
    public function setLayout($e)
    {
        $matches = $e->getRouteMatch();
        $controller = $matches->getParam('controller');
        if (preg_match('/' . __NAMESPACE__ . '\\//i', $controller)) {
            // not a controller from this module
            return;
        }
        if (preg_match('/admin/i', $controller)) {
            // Set the layout template
            $viewModel = $e->getViewModel();
            $viewModel->setTemplate('layout/admin');
        }
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