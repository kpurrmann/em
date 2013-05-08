<?php

namespace Event\Service;

/**
 * Description of EventService
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class EventService implements \Zend\EventManager\EventManagerAwareInterface, \Event\Service\EventServiceInterface
{

    /**
     *
     * @var \Zend\EventManager\EventManagerInterface
     */
    protected $eventManager;

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

    /**
     *
     * @var array
     */
    protected $forms = array();

    public function __construct(\Doctrine\ORM\EntityManager $entityManager, \Zend\Mvc\Controller\Plugin\FlashMessenger $flashMessenger)
    {
        $this->entityManager = $entityManager;
        $this->flashMessenger = $flashMessenger;
    }

    /**
     *
     * @return \Zend\EventManager\EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     *
     * @param \Zend\EventManager\EventManagerInterface $eventManager
     */
    public function setEventManager(\Zend\EventManager\EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(__CLASS__));
        $this->eventManager = $eventManager;
    }

    /**
     *
     * @param string $type
     * @return \Zend\Form\Form
     */
    public function getForm($type = 'default', $id = null)
    {
        if (!isset($this->forms[$type])) {
            $this->eventManager->trigger('set-event-form', __CLASS__, array('type' => $type, 'id' => $id));
        }
        return $this->forms[$type];
    }

    /**
     *
     * @param \Zend\Form\Form $form
     * @param string $type
     */
    public function setForm(\Zend\Form\Form $form, $type = 'default')
    {
        $this->forms[$type] = $form;
    }

    /**
     *
     * @return \Doctrine\Common\Collections\ArrayCollection<\Event\Entity\Event>
     */
    public function getEvents()
    {
        $repo = $this->entityManager->getRepository('\Event\Entity\Event');
        $adapter = new \DoctrineORMModule\Paginator\Adapter\DoctrinePaginator(new \Doctrine\ORM\Tools\Pagination\Paginator($repo->createQueryBuilder('id')));
        $paginator = new \Zend\Paginator\Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        return $paginator;
    }

    /**
     *
     * @param int||string $id
     * @return \Event\Entity\Event
     */
    public function getEntry($id)
    {
        $repo = $this->entityManager->getRepository('\Event\Entity\Event');
        return $repo->find($id);
    }

    /**
     *
     * @param array $data
     */
    public function save($data)
    {
        $form = $this->getForm();
        $form->setData($data);

        if ($form->isValid()) {

            $repo = $this->entityManager->getRepository('\Event\Entity\Event');
            $event = $repo->find($data['id']);

            if (!$event) {
                $event = new \Event\Entity\Event();
            }

            $event->exchangeArray($form->getData());
            $this->entityManager->persist($event);
            $this->entityManager->flush();
            $this->flashMessenger->addSuccessMessage('Erfolgreich gespeichert.');
        }
    }

    public function delete($id)
    {
        $repo = $this->entityManager->getRepository('\Event\Entity\Event');
        $event = $repo->find($id);
        $this->entityManager->remove($event);
        $this->entityManager->flush();
        $this->flashMessenger->addSuccessMessage('Gelöscht');
    }

}
