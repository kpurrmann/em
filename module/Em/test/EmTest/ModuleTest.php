<?php

/**
 * @link      https://github.com/weierophinney/PhlySimplePage for the canonical source repository
 * @copyright Copyright (c) 2012 Matthew Weier O'Phinney (http://mwop.net)
 * @license   https://github.com/weierophinney/PhlySimplePage/blog/master/LICENSE.md New BSD License
 */

namespace EmTest;

use PHPUnit_Framework_TestCase as TestCase;
use stdClass;
use Zend\EventManager\EventManager;
use Zend\EventManager\SharedEventManager;
use Zend\EventManager\StaticEventManager;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

/**
 * Unit tests for PhlySimplePage\Module
 */
class ModuleTest extends TestCase
{

    /**
     *
     * @var TestAsset\Application
     */
    protected $application;

    /**
     *
     * @var MvcEvent
     */
    protected $event;

    /**
     *
     * @var \Em\Module
     */
    protected $module;

    public function setUp()
    {
        $this->events = new EventManager();
        $this->sharedEvents = new SharedEventManager();
        $this->events->setSharedManager($this->sharedEvents);

        $this->application = new TestAsset\Application();
        $this->application->setEventManager($this->events);

        $this->event = new MvcEvent();
        $this->event->setApplication($this->application);
        $this->event->setTarget($this->application);
        $this->event->setRouteMatch(new \Zend\Mvc\Router\Http\RouteMatch(array()));

        $this->module = new \Em\Module();
    }

    public function tearDown()
    {
        // Need to do this to ensure other tests in suite do not get state
        StaticEventManager::resetInstance();
    }

    protected function getEmptyMockForServiceManager()
    {
        $services = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $services->expects($this->once())
           ->method('has')
           ->will($this->returnValue(false));
        return $services;
    }

    public function testEventManagerHasSetLayout()
    {
        $this->module->onBootstrap($this->event);
        $events = $this->application->getEventManager();
        $listeners = $events->getListeners(MvcEvent::EVENT_DISPATCH);
        $listener = $listeners->top();
        $this->assertTrue(in_array('setLayout', $listener->getCallback()));
    }

    public function testGetConfig()
    {
        $this->assertTrue(is_array($this->module->getConfig()));
    }

    public function testGetAutoConfig()
    {
        $this->assertTrue(is_array($this->module->getAutoloaderConfig()));
    }

    public function testSetLayout()
    {
        $this->module->setLayout($this->event);
        $this->assertEquals('layout/admin', $this->event->getViewModel()->getTemplate());

        $this->event->setRouteMatch(new \Zend\Mvc\Router\Http\RouteMatch(array('controller' => 'index')));
        $this->event->getViewModel()->setTemplate('layout/layout');
        $this->module->setLayout($this->event);
        $this->assertEquals('layout/layout', $this->event->getViewModel()->getTemplate());
    }

}