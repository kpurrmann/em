<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Event\View\Helper;

class ShowMessagesFactory implements \Zend\ServiceManager\FactoryInterface
{

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {

        $flashMessenger = $serviceLocator->getServiceLocator()->get('ControllerPluginManager')->get('flashMessenger');
        $helper = new ShowMessages($flashMessenger);
        return $helper;
    }

}
