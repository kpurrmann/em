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
              'events' => $this->getEventService()->getEvents()
           ));
    }

    public function editAction()
    {
        $form = $this->getEventService()->getForm('update');

        if ($this->getRequest()->isPost()) {

            if ($cancel = $this->getRequest()->getPost('cancel')) {
                return $this->redirect()->toRoute('events');
            }

            $this->getEventService()->save($this->getRequest()->getPost());
        }

        if ($id = $this->params('id')) {
            $form->bind($this->getEventService()->getEntry($id));
        }

        return new ViewModel(array(
              'form' => $form,
              'id' => $id
           ));
    }

    public function deleteAction()
    {
        if ($id = $this->params('id')) {
            $this->getEventService()->delete($id);
        }
        return $this->redirect()->toRoute('events');
    }

}
