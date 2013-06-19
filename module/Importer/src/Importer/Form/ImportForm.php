<?php

namespace Importer\Form;

/**
 * Description of ImportForm
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class ImportForm extends \Event\Form\Form
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * Adds required Elements
     */
    private function addElements()
    {
        $file = new \Zend\Form\Element\File('file');
        $file->setLabel('Datei');
        $file->setAttribute('id', $file->getName());
        $this->add($file);

        $hidden = new \Zend\Form\Element\Hidden('event');
        $this->add($hidden);

        $this->addSubmitElement('submit', 'Daten importieren');
    }

    /**
     * Adds Inputfilter
     */
    private function addInputFilter()
    {
        $inputFilter = new \Zend\InputFilter\InputFilter();

        $fileInput = new \Zend\InputFilter\FileInput('file');
        $fileInput->setRequired(true);

        $fileInput->getValidatorChain()->attachByName(
           'fileextension', array(
             'extension' => 'xls, ods'
           )
        );

        $fileInput->getFilterChain()->attachByName(
           'filerenameupload', array(
           'target' => '/var/www/em/data/uploads/',
           'randomize' => true,
           'use_upload_extension' => true
           )
        );

        $inputFilter->add($fileInput);
        $this->setInputFilter($inputFilter);
    }

}
