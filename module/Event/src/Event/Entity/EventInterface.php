<?php

namespace Event\Entity;

/**
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
interface EventInterface
{

    /**
     * @return int Returns id of EventEntity
     */
    public function getId();

    /**
     *
     * @param int $id
     * @return EventInterface Returns object of type EventInterface
     */
    public function setId($id);

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
     * @return \Zend\Stdlib\DateTime
     */
    public function getEventDate();

    /**
     *
     * @param \Zend\Stdlib\DateTime $date
     * @return EventInterface
     */
    public function setEventDate(\Zend\Stdlib\DateTime $date);
}