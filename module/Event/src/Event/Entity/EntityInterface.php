<?php

namespace Event\Entity;

/**
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
interface EntityInterface
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
     *
     * @param array $array
     */
    public function exchangeArray(array $array);
}