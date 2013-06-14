<?php

namespace Importer;

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
   'router' => array(
      'routes' => array(
         'importer' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
               'route' => '/importer',
               'defaults' => array(
                  'controller' => 'Importer\Controller\Import',
                  'action' => 'index',
               ),
            ),
            'may_terminate' => true,
            'child_routes' => array(
               'action' => array(
                  'type' => 'segment',
                  'options' => array(
                     'route' => '/:action[/:id]',
                     'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9-]*',
                        'id' => '[0-9]*',
                     ),
                     'defaults' => array(
                        'action' => 'index',
                     ),
                  ),
               ),
            ),
         ),
      ),
   ),
   'controllers' => array(
      'factories' => array(
         'Importer\Controller\Import' => 'Importer\Controller\ImportControllerFactory'
      ),
   ),
   'service_manager' => array(
      'factories' => array(
         'Importer\Service\Import' => 'Importer\Service\ImportServiceFactory',
         'Importer\Form\Import' => 'Importer\Form\ImportFormFactory',
      ),
      'invokables' => array()
   ),
   'view_manager' => array(
      'display_not_found_reason' => true,
      'display_exceptions' => true,
      'doctype' => 'HTML5',
      'template_map' => array(
         'import/import/index' => __DIR__ . '/../view/import/import/index.phtml',
      ),
      'template_path_stack' => array(
         __DIR__ . '/../view',
      ),
   ),
   'doctrine' => array(
      'driver' => array(
         'import' => array(
            'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            'paths' => __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
         ),
         'orm_default' => array(
            'drivers' => array(
               'Import\Entity' => 'import',
            ),
         ),
      ),
   ),
);
