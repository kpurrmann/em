<?php

namespace Event\View\Helper;

/**
 * ViewHelper for display forms
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class ShowForm extends \Zend\View\Helper\AbstractHelper
{

    /**
     *
     * @var \Zend\Form\Form
     */
    protected $form;

    /**
     *
     * @var array
     */
    protected $submitElements = array();

    /**
     *
     * @param \Zend\Form\Form $form
     * @param type $url
     * @param type $class
     * @return type
     * @throws \InvalidArgumentException
     */
    public function __invoke(\Zend\Form\Form $form, $url, $class = 'form-horizontal')
    {
        if (!\Zend\Validator\StaticValidator::execute($url, 'Uri')) {
            throw new \InvalidArgumentException;
        }

        $this->form = $form;

        $this->form->setAttribute('action', $url);
        $form->setAttribute('class', $class);
        $form->prepare();

        $output = $this->getView()->form()->openTag($this->form);
        $output .= $this->renderInputs();
        $output .= $this->renderSubmitButtons();
        $output .= $this->getView()->form()->closeTag();
        
        return $output;
    }

    /**
     *
     * @return string
     */
    protected function renderInputs()
    {
        $output = '';

        foreach ($this->form as $element) {
            if ($element instanceof \Zend\Form\Element\Submit) {
                $this->submitElements[] = $element;
                continue;
            } elseif ($element instanceof \Zend\Form\Element\Csrf
               || $element instanceof \Zend\Form\Element\Hidden) {
                $output .= $this->getView()->formElement($element);
            }

            $element->setLabelAttributes(array('class' => 'control-label'));
            $output .= '<div class="control-group">';
            if ($element->getLabel()) {
                $output .= $this->getView()->formLabel($element);
            }
            $output .= '<div class="controls">';
            $output .= $this->getView()->formElement($element);
            $output .= $this->getView()->formElementErrors($element);
            $output .= '</div>';
            $output .= '</div>';
        }
        return $output;
    }

    /**
     *
     * @return string
     */
    protected function renderSubmitButtons()
    {
        $output = '';
        if (!empty($this->submitElements)) {
            $output .= '<div class="form-actions">';
            foreach ($this->submitElements as $element) {
                if ($element instanceof \Zend\Form\ElementInterface) {
                    $output .= $this->getView()->formElement($element) . ' ';
                }
            }
            $output .= '</div>';
        }
        return $output;
    }

}
