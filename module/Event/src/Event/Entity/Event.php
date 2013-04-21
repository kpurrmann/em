<?php

namespace Event\Entity;

/**
 * Description of Event
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class Event implements EventInterface
{

    /**
     *
     * @var int
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $title;

    /**
     *
     * @var \Zend\Stdlib\DateTime
     */
    protected $event_date;

    /**
     *
     * @return \Zend\Stdlib\DateTime
     */
    public function getEventDate()
    {
        return $this->event_date;
    }

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     * @param \Zend\Stdlib\DateTime $date
     * @return \Event\Entity\Event
     */
    public function setEventDate(\Zend\Stdlib\DateTime $date)
    {
        $this->event_date = $date;
        return $this;
    }

    /**
     *
     * @param type $id
     * @return \Event\Entity\Event
     * @throws \InvalidArgumentException
     */
    public function setId($id)
    {
        if (!is_numeric($id)) {
            throw new \InvalidArgumentException();
        }

        $this->id = $id;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

}
