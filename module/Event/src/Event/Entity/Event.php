<?php

/**
 * Description of Event
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */

namespace Event\Entity;

use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Annotation\Type("Event\Form\Form")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("Event")
 * @ORM\Entity(repositoryClass="Event\Repository\EventRepository")
 * @ORM\Table(name="events")
 */
class Event extends Entity implements EventInterface
{

    /**
     *
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Required(true)
     * @Annotation\Options({"label":"Titel des Events"})
     * @ORM\Column(type="string")
     * @var string
     */
    protected $title;

    /**
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Required(false)
     * @Annotation\Options({"label":"Beschreibung"})
     * @ORM\Column(type="text")
     * @var string
     */
    protected $description;

    /**
     * @Annotation\Type("Zend\Form\Element\DateTimeLocal")
     * @Annotation\Options({"label":"Datum"})
     * @Annotation\Required(true)
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $event_date;

    /**
     * @Annotation\Exclude()
     * @ORM\OneToMany(targetEntity="EventsGuests", mappedBy="event_id", cascade="all")
     * @ORM\JoinTable(name="events_guests")
     * */
    protected $guests;

    /**
     * @Annotation\Exclude()
     * @ORM\ManyToMany(targetEntity="Property", cascade="all")
     * */
    protected $properties;

    /**
     * @Annotation\Exclude()
     * @var int Count of Confirmations
     * */
    protected $confirmations;

    /**
     * @Annotation\Exclude()
     * @var int Count of Cancellations
     * */
    protected $cancellations;

    /**
     * @Annotation\Exclude()
     * @var int Count of Opens
     * */
    protected $opens;

    public function __construct()
    {
        $this->guests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->properties = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     *
     * @param string $format Set format of return date
     * @return \DateTime
     */
    public function getEventDate($format = null)
    {
        if ($format == 'string') {
            return $this->event_date->format('d.m.Y H:i');
        }
        return $this->event_date;
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
     * @param \DateTime $date
     * @return \Event\Entity\Event
     */
    public function setEventDate($date)
    {
        $this->event_date = new \DateTime($date);
        return $this;
    }

    /**
     *
     * @param string $title
     * @return \Event\Entity\Event
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @param type $description
     * @return \Event\Entity\Event
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     *
     * @return type
     */
    public function getGuests()
    {
        return $this->guests;
    }

    /**
     * 
     * @return type
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * 
     * @return int
     */
    public function getConfirmations()
    {
        return $this->confirmations;
    }

    /**
     *
     * @param int $confirmations
     */
    public function setConfirmations($confirmations)
    {
        $this->confirmations = $confirmations;
    }

    /**
     *
     * @return int
     */
    public function getCancellations()
    {
        return $this->cancellations;
    }

    /**
     *
     * @param int $cancellations
     */
    public function setCancellations($cancellations)
    {
        $this->cancellations = $cancellations;
    }

    /**
     *
     * @return int
     */
    public function getOpens()
    {
        return $this->opens;
    }

    /**
     *
     * @param int $opens
     */
    public function setOpens($opens)
    {
        $this->opens = $opens;
    }

}
