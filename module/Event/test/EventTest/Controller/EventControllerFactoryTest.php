<?php

namespace EventTest\Controller;

/**
 * Description of EventControllerFactoryTest
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class EventControllerFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Event\Controller\EventControllerFactory
     */
    protected $factory;

    public function setUp()
    {
//        $this->events = new EventManager();
//        $this->sharedEvents = new SharedEventManager();
//        $this->events->setSharedManager($this->sharedEvents);
//
//        $this->application = new TestAsset\Application();
//        $this->application->setEventManager($this->events);
//        $this->application->setServiceManager(Bootstrap::getServiceManager());
//        $this->event = new MvcEvent();
//        $this->event->setApplication($this->application);
//        $this->event->setTarget($this->application);
//        $this->event->setRouteMatch(new \Zend\Mvc\Router\Http\RouteMatch(array()));
//
//        $this->module = new \Event\Module();
    }

    public function testFactoryCreatesEventControllerInstance()
    {
        $this->markTestIncomplete();
        $this->dispatch('/');
        $this->assertResponseStatusCode(200);

//        $this->assertModuleName('Album');
//        $this->assertControllerName('Album\Controller\Album');
//        $this->assertControllerClass('AlbumController');
//        $this->assertMatchedRouteName('album');
    }

}
