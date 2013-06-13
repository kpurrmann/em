<?php

namespace Event\Repository;

/**
 * Description of GuestRepository
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class GuestRepository extends \Doctrine\ORM\EntityRepository
{

    public function getCountStatusFromEvent($event, $confirmation = 0)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('g.id, count(g)')
           ->from('Event\Entity\Guest', 'g')
           ->join('Event\Entity\EventsGuests', 'eg')
           ->where('eg.event_id= :event')
           ->groupBy('g.id')
           ->setParameter('event', $event)
           ->andWhere('eg.confirmation = ' . $confirmation);


        /**
         * Need to make it complicated, because of groupBy and getSingleScalarResult doesnt work
         */
        $return = $qb->getQuery()->getResult();

        if (isset($return[1][1])) {
            return $return[1][1];
        }

        return 0;
    }

}
