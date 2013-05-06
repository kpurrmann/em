<?php

namespace Event\Form;

/**
 * Description of EventFormFactory
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class EventFormFactory implements \Zend\ServiceManager\FactoryInterface
{

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');

        /* @var $form Event\Form\Form */
        $annotationBulder = new \Zend\Form\Annotation\AnnotationBuilder();
        $form = $annotationBulder->createForm('Event\Entity\Event');
        $form->setHydrator(new \Event\Form\Hydrator\EventHydrator($em, '\Event\Entity\Event', false));
        $form->addSubmitElement('submit', 'Speichern');
        $form->addSubmitElement('cancel', 'Abbrechen');
        return $form;
    }

}
