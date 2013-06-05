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
 * @ORM\Table(name="guests", uniqueConstraints={@ORM\UniqueConstraint(name="email_idx", columns={"email"})})
 */
class Guest extends Entity
{

    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    protected $prename;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $email;

    /**
     * @ORM\ManyToMany(targetEntity="\Event\Entity\Event", mappedBy="guests")
     * */
    protected $events;

    public function __construct()
    {
        $this->events= new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * 
     * @return string
     */
    public function getPrename()
    {
        return $this->prename;
    }

    /**
     *
     * @param string $prename
     */
    public function setPrename($prename)
    {
        $this->prename = $prename;
    }

    /**
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

}
