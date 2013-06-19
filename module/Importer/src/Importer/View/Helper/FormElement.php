<?php

namespace Importer\View\Helper;

/**
 * Description of FormElement
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class FormElement extends \Zend\Form\View\Helper\FormElement
{

    public function render(\Zend\Form\ElementInterface $element)
    {
        $wrapBefore = '';
        $wrapAfter = '';
        if ($element->getAttribute('type') == 'file') {
            $wrapBefore = '<span class="btn btn-success fileinput-button">
                                <i class="icon-plus icon-white"></i>
                                <span>' . $element->getLabel() . '</span>';
            $wrapAfter = '</span>';
        }
        return $wrapBefore . parent::render($element) . $wrapAfter;
    }

}
