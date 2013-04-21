<?php

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
         'home' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
               'route' => '/',
               'defaults' => array(
                  'controller' => 'Event\Controller\Event',
                  'action' => 'index',
               ),
            ),
         ),
         // The following is a route to simplify getting started creating
         // new controllers and actions without needing to create a new
         // module. Simply drop new controllers in, and you can access them
         // using the path /application/:controller/:action
      ),
   ),
   'service_manager' => array(
      'factories' => array(
         'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
      ),
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
      'invokables' => array(
         'Event\Controller\Index' => 'Event\Controller\IndexController',
         'Event\Controller\Event' => 'Event\Controller\EventController'
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
);
