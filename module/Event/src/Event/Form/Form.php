<?php

namespace Event\Form;

/**
 * Description of FormFactory
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class Form extends \Zend\Form\Form
{

    /**
     *
     * @param type $name
     * @param type $label
     */
    public function addSubmitElement($name = 'save', $label = ' Speichern')
    {
        $element = new \Zend\Form\Element\Submit($name);
        $element->setValue($label);
        $element->setAttribute('class', 'btn');
        $this->add($element);
    }

}
