<?php

namespace Importer\Service;

/**
 * Description of ImportService
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class ImportService implements ImportServiceInterface
{

    /**
     *
     * @var \Importer\Filter\PrepareForDatabase
     */
    protected $databaseFilter;

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     *
     * @return \Importer\Filter\PrepareForDatabase
     */
    public function getDatabaseFilter()
    {
        return $this->databaseFilter;
    }

    /**
     *
     * @param type $name
     */
    public function getPropertyByName($name)
    {

    }

    /**
     *
     * @param string $path
     */
    public function parseExcel($path)
    {

        if (is_file($path)) {
            $excel = \PHPExcel_IOFactory::createReaderForFile($path);
            /* @var $sheet \PHPExcel */
            $sheet = $excel->load($path);
            /* @var $active \PHPExcel_Worksheet */
            $active = $sheet->getActiveSheet();

            /* @var $row \PHPExcel_Worksheet_Row */
            /* @var $cell \PHPExcel_Cell */
            foreach ($active->getRowIterator(2) as $k => $row) {
                foreach ($row->getCellIterator() as $column => $cell) {
                    $array[$k][$this->getDatabaseFilter()->filter($active->getCellByColumnAndRow($column, 1)->getValue())] = $cell->getValue();
                }
            }
            if (is_array($array)) {
                $array = $this->setGuestData($array);
            }
        } else {
            throw new \Zend\File\Transfer\Exception();
        }
    }

    private function setGuestData(&$array)
    {
        $guestRepository = $this->entityManager->getRepository('\Event\Entity\Guest');
        if (is_array($array)) {

            // @todo Add option for only update association
            if ($toDelete = $this->entityManager->getRepository('\Event\Entity\EventsGuests')->findBy(array('event_id' => 1))) {
                foreach ($toDelete as $element) {
                    $this->entityManager->remove($element);
                }
                $this->entityManager->flush();
            }

            foreach ($array as $data) {

                if (key_exists('email', $data)) {
                    if ($guest = $guestRepository->findOneBy(array('email' => $data['email']))) {
                        
                    } else {
                        $guest = new \Event\Entity\Guest();
                        $guest->setEmail($data['email']);
                        $guest->setLastname($data['name']);
                        $guest->setPrename($data['vorname']);
                        $this->entityManager->persist($guest);
                        $this->entityManager->flush($guest);
                    }

                    unset($data['email']);
                    unset($data['vorname']);
                    unset($data['name']);

                    if (!empty($data)) {
                        foreach ($data as $key => $value) {
                            if ($property = $this->entityManager->getRepository('\Event\Entity\Property')->findOneBy(array('identifier' => $key))) {

                            } else {
                                $property = new \Event\Entity\Property();
                                $property->setLabel(ucfirst($key));
                                $property->setIdentifier($key);
                                $this->entityManager->persist($property);
                                $this->entityManager->flush($property);
                            }


                            $guestProperty = new \Event\Entity\GuestsProperties();
                            $guestProperty->setGuest($guest);
                            $guestProperty->setProperty($property);

                            if ($toDelete = $this->entityManager->getRepository('\Event\Entity\GuestsProperties')->findOneBy(array('guest_id' => $guest->getId(), 'property_id' => $property->getId()))) {
                                $this->entityManager->remove($toDelete);
                                $this->entityManager->flush($toDelete);
                            }

                            $guestProperty->setValue($value);
                            $this->entityManager->persist($guestProperty);
                        }
                        $this->entityManager->flush();
                    }

                    $eventGuest = new \Event\Entity\EventsGuests();
                    $eventGuest->setEvent($this->entityManager->getRepository('\Event\Entity\Event')->find(1));
                    $eventGuest->setGuest($guest);
                    $eventGuest->setConfirmation(0);
                    $eventGuest->setCode(substr(md5(uniqid()), 0, 6));

                    $this->entityManager->persist($eventGuest);
                    $this->entityManager->flush();
                }
            }
        }
        return $array;
    }

    /**
     *
     * @param \Importer\Filter\PrepareForDatabase $filter
     */
    public function setDatabaseFilter(\Importer\Filter\PrepareForDatabase $filter)
    {
        $this->databaseFilter = $filter;
    }

    /**
     * 
     * @return \DoctrineORMModule\Options\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

}
