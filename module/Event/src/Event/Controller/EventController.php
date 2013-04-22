<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Event\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EventController extends AbstractActionController
{

    /**
     *
     * @var \EventService
     */
    protected $eventService;

    public function setEventService(\Event\Service\EventServiceInterface $eventService)
    {
        $this->eventService = $eventService;
        return $this;
    }

    public function getEventService()
    {
        return $this->eventService;
    }

    public function indexAction()
    {
        return new ViewModel(array(
           'form' => $this->getEventService()->getForm('update')
        ));
    }

}
