<?php

namespace Event;

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
         'events' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
               'route' => '/events',
               'defaults' => array(
                  'controller' => 'Event\Controller\Event',
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
   'service_manager' => array(
      'factories' => array(
         'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
         'Event\Form\Event' => 'Event\Form\EventFormFactory',
         'Event\Service\Event' => 'Event\Service\EventServiceFactory'
      ),
      'invokables' => array()
   ),
   'translator' => array(
      'locale' => 'en_US',
      'translation_file_patterns' => array(
         array(
            'type' => 'gettext',
            'base_dir' => __DIR__ . '/../language',
            'pattern' => '%s.mo',
         ),
      ),
   ),
   'controllers' => array(
      'factories' => array(
         'Event\Controller\Event' => 'Event\Controller\EventControllerFactory'
      ),
   ),
   'view_helpers' => array(
      'invokables' => array(
         'showForm' => 'Event\View\Helper\ShowForm',
         'HtmlTable' => 'Event\View\Helper\HtmlTable',
      ),
   ),
   'view_manager' => array(
      'display_not_found_reason' => true,
      'display_exceptions' => true,
      'doctype' => 'HTML5',
      'not_found_template' => 'error/404',
      'exception_template' => 'error/index',
      'template_map' => array(
         'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
         'layout/admin' => __DIR__ . '/../view/layout/admin.phtml',
         'event/event/index' => __DIR__ . '/../view/event/event/index.phtml',
         'error/404' => __DIR__ . '/../view/error/404.phtml',
         'error/index' => __DIR__ . '/../view/error/index.phtml',
      ),
      'template_path_stack' => array(
         __DIR__ . '/../view',
      ),
   ),
   'doctrine' => array(
      'driver' => array(
         'event' => array(
            'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            'paths' => __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
         ),
         'orm_default' => array(
            'drivers' => array(
               'Event\Entity' => 'event',
            ),
         ),
      ),
   ),
);
