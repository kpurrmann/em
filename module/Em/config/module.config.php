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
                  'controller' => 'Em\Controller\Index',
                  'action' => 'index',
               ),
            ),
         ),
         // The following is a route to simplify getting started creating
         // new controllers and actions without needing to create a new
         // module. Simply drop new controllers in, and you can access them
         // using the path /application/:controller/:action
         'em' => array(
            'type' => 'Literal',
            'options' => array(
               'route' => '/',
               'defaults' => array(
                  '__NAMESPACE__' => 'Em\Controller',
                  'controller' => 'Index',
                  'action' => 'index',
               ),
            ),
            'may_terminate' => true,
            'child_routes' => array(
               'default' => array(
                  'type' => 'Segment',
                  'options' => array(
                     'route' => '/[:controller[/:action]]',
                     'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                     ),
                  ),
               ),
            ),
         ),
         'customer' => array(
            'type' => 'Literal',
            'options' => array(
               'route' => '/customer',
               'defaults' => array(
                  'controller' => 'zfcuser',
                  'action' => 'index',
               ),
            ),
         ),
         'administration' => array(
            'type' => 'Literal',
            'options' => array(
               'route' => '/customer',
               'defaults' => array(
                  '__NAMESPACE__' => 'Em\Controller',
                  'controller' => 'admin',
                  'action' => 'index',
               ),
            ),
            'may_terminate' => true,
            'child_routes' => array(
               'default' => array(
                  'type' => 'Segment',
                  'options' => array(
                     'route' => '/[:controller[/:action]]',
                     'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
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
         'Em\Controller\Index' => 'Em\Controller\IndexController',
         'Em\Controller\Admin' => 'Em\Controller\AdminController'
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
         'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
         'error/404' => __DIR__ . '/../view/error/404.phtml',
         'error/index' => __DIR__ . '/../view/error/index.phtml',
      ),
      'template_path_stack' => array(
         __DIR__ . '/../view',
      ),
   ),
);