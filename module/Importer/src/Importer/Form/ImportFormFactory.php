<?php

namespace Importer\Form;

/**
 * Description of ImportFormFactory
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class ImportFormFactory implements \Zend\ServiceManager\FactoryInterface
{

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {

        $form = new ImportForm();
        return $form;
    }

}
