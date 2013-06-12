<?php

namespace Event\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Property
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 * @ORM\Entity
 * @ORM\Table(name="properties")
 */
class Property implements PropertyInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var int
     */
    protected $id;

    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    protected $label;

    /**
     * @ORM\ManyToMany(targetEntity="Event")
     * @var type
     */
    protected $events;


    /**
     * @ORM\OneToMany(targetEntity="GuestsProperties", mappedBy="property_id")
     * @ORM\JoinTable(name="guests_properties")
     * */
    protected $guests;

    /**
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

}
