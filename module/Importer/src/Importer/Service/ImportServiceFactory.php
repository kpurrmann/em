<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Importer\Service;

class ImportServiceFactory implements \Zend\ServiceManager\FactoryInterface
{

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {

        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $service = new ImportService();
        $filter = new \Importer\Filter\PrepareForDatabaseFactory();
        $flashMessenger = $serviceLocator->get('ControllerPluginManager')->get('flashMessenger');
        $service->setDatabaseFilter($filter->getFilter());
        $service->setFlashMessenger($flashMessenger);
        $service->setEntityManager($entityManager);
        return $service;
    }

}
