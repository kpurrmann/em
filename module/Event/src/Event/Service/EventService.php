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
     * @var array
     */
    protected $forms = array();

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
    public function getForm($type = 'default')
    {
        if (!isset($this->forms[$type])) {
            $this->eventManager->trigger('set-event-form', __CLASS__, array('type' => $type));
            return $this->forms[$type];
        }
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

}
