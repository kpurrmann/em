<?php

namespace EventTest\Service;

/**
 * Description of EventServiceTest
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class EventServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Event\Service\EventService
     */
    protected $eventService;

    protected function setUp()
    {
        $this->eventService = new \Event\Service\EventService();
    }

    public function testEventServiceImplementsInterfaces()
    {
        $this->assertInstanceOf('\Zend\EventManager\EventManagerAwareInterface', $this->eventService);
        $this->assertInstanceOf('\Event\Service\EventServiceInterface', $this->eventService);
    }

    public function testEventServiceSetsForm()
    {
        $form = new \Zend\Form\Form('default');
        $this->eventService->setForm($form);
        $this->assertEquals($form, $this->eventService->getForm());
    }

    public function testEventServiceGetsFormIfFormIsNotSetYet()
    {
        $mockEvent = $this->getMock('\Zend\EventManager\EventManager', array('trigger', 'setIdentifiers'), array(), '', false);
        $mockEvent->expects($this->any())->method('trigger')->will($this->returnCallback(function($form) {
                  $form = new \Zend\Form\Form('default');
                  $this->eventService->setForm($form);
              }));
        $this->eventService->setEventManager($mockEvent);
        $form = $this->eventService->getForm();
        $this->assertInstanceOf('\Zend\Form\Form', $form);
    }

    public function testEventServiceGetsEventManager()
    {
        $mockEvent = $this->getMock('\Zend\EventManager\EventManager');
        $this->eventService->setEventManager($mockEvent);
        $this->assertEquals($mockEvent, $this->eventService->getEventManager());
    }

}
