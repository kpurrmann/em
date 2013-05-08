<?php

namespace EventTest\Form;

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
class EventTest extends TestCase
{

    /**
     *
     * @var \Event\Form\EventFormFactory
     */
    protected $eventFormFactory;

    /**
     *
     * @var Application
     */
    protected $application;

    protected function setUp()
    {
        $this->events = new EventManager();
//        $this->sharedEvents = new SharedEventManager();
//        $this->events->setSharedManager($this->sharedEvents);

        $this->application = new \EventTest\TestAsset\Application();
        $this->application->setEventManager($this->events);

        $this->event = new MvcEvent();
        $this->event->setApplication($this->application);
        $this->event->setTarget($this->application);
        $this->event->setRouteMatch(new \Zend\Mvc\Router\Http\RouteMatch(array()));

        $this->eventFormFactory = new \Event\Form\EventFormFactory;
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testFactoryReturnsForm()
    {
        $form = $this->eventFormFactory->createService(\EventTest\Bootstrap::getServiceManager());
        $this->assertTrue($form instanceof \Event\Form\Form);
    }

    public function testFormHasSubmitAndDeleteButton()
    {
        $form = $this->eventFormFactory->createService(\EventTest\Bootstrap::getServiceManager());
        $this->assertInstanceOf('\Zend\Form\Element\Submit', $form->get('submit'));
        $this->assertInstanceOf('\Zend\Form\Element\Submit', $form->get('cancel'));
    }

    public function testFormValid()
    {
        /* @var $form \Event\Form\Form */
        $form = $this->eventFormFactory->createService(\EventTest\Bootstrap::getServiceManager());
        $form->setData(array());
        $this->assertFalse($form->isValid());

        $form->setData(array('id' => 5));
        $this->assertFalse($form->isValid());

        $form->setData(array('title' => 5));
        $this->assertFalse($form->isValid());

        $form->setData(array('event_date' => 5));
        $this->assertFalse($form->isValid());

    }

}