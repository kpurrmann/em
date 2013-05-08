<?php

namespace EventTest;

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
     * @var \Event\Module
     */
    protected $module;

    public function setUp()
    {
        $this->events = new EventManager();
//        $this->sharedEvents = new SharedEventManager();
//        $this->events->setSharedManager($this->sharedEvents);

        $this->application = new TestAsset\Application();
        $this->application->setEventManager($this->events);
        $this->application->setServiceManager(Bootstrap::getServiceManager());
        $this->event = new MvcEvent();
        $this->event->setApplication($this->application);
        $this->event->setTarget($this->application);
        $this->event->setRouteMatch(new \Zend\Mvc\Router\Http\RouteMatch(array()));

        $this->module = new \Event\Module();
    }

    public function tearDown()
    {
        // Need to do this to ensure other tests in suite do not get state
//        StaticEventManager::resetInstance();
    }

    protected function getEmptyMockForServiceManager()
    {
        $services = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $services->expects($this->once())
           ->method('has')
           ->will($this->returnValue(false));
        return $services;
    }

    public function testGetConfig()
    {
        $this->assertTrue(is_array($this->module->getConfig()));
    }

    public function testGetAutoConfig()
    {
        $this->assertTrue(is_array($this->module->getAutoloaderConfig()));
    }

    public function testOnBootstrap()
    {
        $this->module->onBootstrap($this->event->setName(MvcEvent::EVENT_BOOTSTRAP));
        $serviceLocator = $this->application->getServiceManager();
        /* @var $sharedEventManager \Zend\EventManager\SharedEventManager */
        $sharedEventManager = $serviceLocator->get('SharedEventManager');
        $registeredEvent = $sharedEventManager->getEvents('Event\Service\EventService');
        $this->assertTrue(is_array($registeredEvent));
    }

    public function testOnFormSet()
    {
        $this->markTestIncomplete();
        $this->module->onBootstrap($this->event->setName(MvcEvent::EVENT_BOOTSTRAP));
        $this->module->onFormSet($this->event->setParam('type', 'default'));
    }


}