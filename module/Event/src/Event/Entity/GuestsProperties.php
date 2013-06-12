<?php

/**
 * Description of Event
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */

namespace Event\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="guests_properties")
 */
class GuestsProperties extends Entity
{

    /**
     * @ORM\ManyToOne(targetEntity="Property", inversedBy="guests")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    protected $property_id;

    /**
     * @ORM\ManyToOne(targetEntity="Guest", inversedBy="properties")
     * @ORM\JoinColumn(name="guest_id", referencedColumnName="id")
     */
    protected $guest_id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $value;

    public function getProperty()
    {
        return $this->property_id;
    }

    public function getPropertyLabel()
    {
        return $this->property_id->getLabel();
    }

    public function getGuest()
    {
        return $this->guest_id;
    }

    public function getValue()
    {
        return $this->value;
    }

}
