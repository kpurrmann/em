<?php

namespace EventTest\TestAsset;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\ApplicationInterface;

class Application implements ApplicationInterface
{

    protected $events;
    public $services;
    protected $serviceManager;

    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers(array(
           __CLASS__,
           get_class($this),
           'Zend\Mvc\Application',
           'Zend\Mvc\ApplicationInterface',
        ));
        $this->events = $events;
        return $this;
    }

    /**
     *
     * @return EventManager
     */
    public function getEventManager()
    {
        if (!$this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }

    public function getRequest()
    {

    }

    public function getResponse()
    {

    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(\Zend\ServiceManager\ServiceLocatorInterface $service)
    {
        $this->serviceManager = $service;
    }

    public function run()
    {
        
    }

}