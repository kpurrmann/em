<?php

namespace Event\Service;

/**
 * Description of EventServiceInterface
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
interface GuestServiceInterface
{

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager);

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager();

    /**
     *
     * @param \Zend\Mvc\Controller\Plugin\FlashMessenger $flashMessenger
     */
    public function setFlashMessenger(\Zend\Mvc\Controller\Plugin\FlashMessenger $flashMessenger);

    /**
     * @return \Zend\Mvc\Controller\Plugin\FlashMessenger
     */
    public function getFlashMessenger();
}
