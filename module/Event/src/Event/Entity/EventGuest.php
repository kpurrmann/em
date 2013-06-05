<?php

namespace Event\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="events_guests")
 */
class EventGuest
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="\Event\Entity\Event", inversedBy="guests", cascade={"all"})
     * @var \Event\Entity\Event
     */
    protected $event;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="\Event\Entity\Guests", inversedBy="events", cascade={"all"})
     * @var \Event\Entity\Guest
     */
    protected $guest;

}
