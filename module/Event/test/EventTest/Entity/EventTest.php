<?php

namespace EventTest\Entity;

use PHPUnit_Framework_TestCase as TestCase;
use Event\Entity\Event as EventEntity;
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
class EventTest extends TestCase
{

    /**
     *
     * @var \Event\Entity\Event
     */
    protected $eventEntity;

    protected function setUp()
    {
        $this->events = new EventManager();
        $this->sharedEvents = new SharedEventManager();
        $this->events->setSharedManager($this->sharedEvents);

        $this->application = new \EventTest\TestAsset\Application();
        $this->application->setEventManager($this->events);

        $this->event = new MvcEvent();
        $this->event->setApplication($this->application);
        $this->event->setTarget($this->application);
        $this->event->setRouteMatch(new \Zend\Mvc\Router\Http\RouteMatch(array()));

        $this->eventEntity = new EventEntity();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testEventEntityImplementsEventEntityInterface()
    {
        $this->assertTrue($this->eventEntity instanceof \Event\Entity\Event);
    }

    public function testSetEventDateAndGetDate()
    {
        $date = new \Zend\Stdlib\DateTime();
        $this->eventEntity->setEventDate($date);

        $this->assertEquals($date, $this->eventEntity->getEventDate());
    }

    public function testSetTitleAndGetTitle()
    {
        $title = 'Mein Titel';
        $this->eventEntity->setTitle($title);
        $this->assertEquals($title, $this->eventEntity->getTitle());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetIdAndGetTitle()
    {

        $id = 5;
        $this->eventEntity->setId($id);
        $this->assertEquals($id, $this->eventEntity->getId());

        $id = 'TEXT';
        $this->eventEntity->setId($id);
    }

}