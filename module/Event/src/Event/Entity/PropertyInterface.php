<?php

namespace Event\Entity;

/**
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
interface PropertyInterface
{

    /**
     *
     * @return int
     */
    public function getId();

    /**
     * @return $string
     */
    public function getLabel();

    /**
     *
     * @param string $label
     */
    public function setLabel($label);

}