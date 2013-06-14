<?php

namespace Importer\Service;

/**
 * Description of ImportService
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class ImportService implements ImportServiceInterface, \Zend\EventManager\EventManagerAwareInterface
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
     * @var \Zend\Mvc\Controller\Plugin\FlashMessenger
     */
    protected $flashMessenger;
    protected $form;

    /**
     *
     * @var \Zend\EventManager\EventManager
     */
    protected $eventManager;

    public function getFlashMessenger()
    {
        return $this->flashMessenger;
    }

    public function setFlashMessenger($flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

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
     * @return \Importer\Form\ImportForm
     */
    public function getForm()
    {
        $this->eventManager->trigger('set-import-form', __CLASS__);
        return $this->form;
    }

    /**
     *
     * @param \Importer\Form\ImportForm $form
     */
    public function setForm(\Importer\Form\ImportForm $form)
    {
        $this->form = $form;
    }

    /**
     *
     * @param string $path
     */
    public function parseExcel($path, $event)
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
                $array = $this->setGuestData($array, $event);
                $this->flashMessenger->addSuccessMessage('Gästeliste wurde erfolgreich importiert.');
            }
        } else {
            throw new \Zend\File\Transfer\Exception();
        }
    }

    private function setGuestData($array, $event)
    {
        $guestRepository = $this->entityManager->getRepository('\Event\Entity\Guest');
        if (is_array($array)) {

            // @todo Add option for only update association
            if ($toDelete = $this->entityManager->getRepository('\Event\Entity\EventsGuests')->findBy(array('event_id' => $event))) {
                foreach ($toDelete as $element) {
                    $this->entityManager->remove($element);
                }
                $this->entityManager->flush();
            }

            foreach ($array as $data) {

                if (key_exists('email', $data)) {
                    $validator = new \Zend\Validator\EmailAddress();
                    if (!$validator->isValid($data['email'])) {
                        continue;
                    }
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
                    $eventGuest->setEvent($this->entityManager->getRepository('\Event\Entity\Event')->find($event));
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

    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function setEventManager(\Zend\EventManager\EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(__CLASS__));
        $this->eventManager = $eventManager;
    }

}
