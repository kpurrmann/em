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
 * @ORM\Entity
 * @ORM\Table(name="events_guests")
 */
class EventsGuests
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="guests", cascade={"persist"})
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    protected $event_id;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Guest", inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn(name="guest_id", referencedColumnName="id")
     */
    protected $guest_id;

    /**
     * @ORM\Column(type="string")
     * @var type
     */
    protected $code;

    /**
     * @ORM\Column(type="integer", length=1)
     * @var int
     */
    protected $confirmation;

    public function getEvent()
    {
        return $this->event_id;
    }

    public function getGuest()
    {
        return $this->guest_id;
    }

    public function getCode()
    {
        return $this->code;
    }

    /**
     *
     * @return int
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    public function setEvent($event_id)
    {
        $this->event_id = $event_id;
    }

    public function setGuest($guest_id)
    {
        $this->guest_id = $guest_id;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;
    }

}
