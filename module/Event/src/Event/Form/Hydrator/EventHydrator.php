<?php

namespace Event\Form\Hydrator;

/**
 * Description of EventHydrator
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class EventHydrator extends \DoctrineModule\Stdlib\Hydrator\DoctrineObject
{

    /**
     *
     * @param \Event\Entity\EntityInterface $object
     * @return array
     */
    public function extractByReference($object)
    {
        $data = parent::extractByReference($object);
        return $data;
    }

}
