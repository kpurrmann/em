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
 * @ORM\Entity
 * @ORM\Table(name="events")
 */
class Event implements EventInterface
{

    /**
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @Annotation\Validator({"name":"Digits"})
     * @Annotation\Required(false)
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

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
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Validator({"name":"Date", "options" : {"format" : "d.m.Y"}})
     * @Annotation\Options({"label":"Datum"})
     * @Annotation\Required(true)
     * @ORM\Column(type="datetime")
     * @var \Zend\Stdlib\DateTime
     */
    protected $event_date;

    /**
     *
     * @return \Zend\Stdlib\DateTime
     */
    public function getEventDate()
    {
        return $this->event_date->format('d.m.Y');
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
    public function setEventDate($date)
    {
        $this->event_date = new \Zend\Stdlib\DateTime($date);
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
     * @param array $array
     */
    public function exchangeArray(array $array)
    {
        $filter = new \Zend\Filter\Word\UnderscoreToCamelCase();
        foreach ($array as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $method = 'set' . ucfirst($filter->filter($key));
            if (!method_exists($this, $method)) {
                continue;
            }
            $this->$method($value);
        }
    }

}
