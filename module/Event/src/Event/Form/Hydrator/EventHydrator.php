<?php


namespace Event\Form\Hydrator;

/**
 * Description of EventHydrator
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class EventHydrator extends \DoctrineModule\Stdlib\Hydrator\DoctrineObject
{

    public function extractByReference($object)
    {
        $data = parent::extractByReference($object);
        $data['event_date'] = $data['event_date']->format('d.m.Y');
        return $data;
    }

}
