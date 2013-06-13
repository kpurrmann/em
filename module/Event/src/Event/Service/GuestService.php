<?php

namespace Event\Service;

/**
 * Description of EventService
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class GuestService implements \Event\Service\GuestServiceInterface
{

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     *
     * @var \Zend\Mvc\Controller\Plugin\FlashMessenger
     */
    protected $flashMessenger;

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function getFlashMessenger()
    {
        return $this->flashMessenger;
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setFlashMessenger(\Zend\Mvc\Controller\Plugin\FlashMessenger $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

    public function getGuestsByEvent($event)
    {
        return $this->entityManager->getRepository('Event\Entity\Guest')->getCountStatusFromEvent($event);
    }

    public function getStatusByEvent($event, $status = 0)
    {

        return $this->entityManager->getRepository('Event\Entity\Guest')->getCountStatusFromEvent($event, $status);
    }

}
