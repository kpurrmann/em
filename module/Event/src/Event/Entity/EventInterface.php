<?php

namespace Event\Entity;

/**
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
interface EventInterface
{

    /**
     * @return string Returns title of EventEntity
     */
    public function getTitle();

    /**
     *
     * @param string $title
     * @return EventInterface Returns object of type EventInterface
     */
    public function setTitle($title);

    /**
     * @return string Returns description of EventEntity
     */
    public function getDescription();

    /**
     *
     * @param string $description
     * @return EventInterface Returns object of type EventInterface
     */
    public function setDescription($description);

    /**
     * @return \Zend\Stdlib\DateTime
     */
    public function getEventDate();

    /**
     *
     * @param \Zend\Stdlib\DateTime $date
     * @return EventInterface
     */
    public function setEventDate($date);
}