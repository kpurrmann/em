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
class GuestsProperties
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Property", inversedBy="guests")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    protected $property_id;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Guest", inversedBy="properties")
     * @ORM\JoinColumn(name="guest_id", referencedColumnName="id")
     */
    protected $guest_id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $value;

    /**
     *
     * @return Property
     */
    public function getProperty()
    {
        return $this->property_id;
    }

    /**
     *
     * @return string
     */
    public function getPropertyLabel()
    {
        return $this->property_id->getLabel();
    }

    /**
     *
     * @return Guest
     */
    public function getGuest()
    {
        return $this->guest_id;
    }

    /**
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     *
     * @param Property $property_id
     */
    public function setProperty($property_id)
    {
        $this->property_id = $property_id;
    }

    /**
     *
     * @param Guest $guest_id
     */
    public function setGuest($guest_id)
    {
        $this->guest_id = $guest_id;
    }

    /**
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}
