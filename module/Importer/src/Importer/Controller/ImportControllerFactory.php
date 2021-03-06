<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Importer\Controller;

class ImportControllerFactory implements \Zend\ServiceManager\FactoryInterface
{

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $controller = new ImportController();
        $sm = $serviceLocator->getServiceLocator();
        $importService = $sm->get('Importer\Service\Import');
        $controller->setImportService($importService);
        return $controller;
    }

}
