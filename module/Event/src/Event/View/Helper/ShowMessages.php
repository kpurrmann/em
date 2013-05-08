<?php

namespace Event\View\Helper;

/**
 * Description of ShowMessages
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class ShowMessages extends \Zend\Form\View\Helper\AbstractHelper
{

    /**
     *
     * @var \Zend\Mvc\Controller\Plugin\FlashMessenger
     */
    protected $flashMessenger;

    /**
     *
     * @param \Zend\Mvc\Controller\Plugin\FlashMessenger $flashMessenger
     */
    public function __construct(\Zend\Mvc\Controller\Plugin\FlashMessenger $flashMessenger)
    {
        $this->setFlashMessenger($flashMessenger);
    }

    /**
     *
     * @return string
     */
    public function __invoke()
    {
        $output = '';

        if ($this->flashMessenger->hasCurrentErrorMessages()) {
            $output .= $this->createMessages($this->flashMessenger->getCurrentErrorMessages(), \Zend\Mvc\Controller\Plugin\FlashMessenger::NAMESPACE_ERROR);
        }

        if ($this->flashMessenger->hasCurrentSuccessMessages()) {
            $output .= $this->createMessages($this->flashMessenger->getCurrentSuccessMessages(), \Zend\Mvc\Controller\Plugin\FlashMessenger::NAMESPACE_SUCCESS);
        }

        if ($this->flashMessenger->hasCurrentInfoMessages()) {
            $output .= $this->createMessages($this->flashMessenger->getCurrentInfoMessages(), \Zend\Mvc\Controller\Plugin\FlashMessenger::NAMESPACE_INFO);
        }

        if ($this->flashMessenger->hasCurrentMessages()) {
            $output .= $this->createMessages($this->flashMessenger->getCurrentMessages(), \Zend\Mvc\Controller\Plugin\FlashMessenger::NAMESPACE_INFO);
        }


        $this->flashMessenger->clearCurrentMessages();
        $this->flashMessenger->clearCurrentMessagesFromNamespace('error');
        $this->flashMessenger->clearCurrentMessagesFromNamespace('success');
        $this->flashMessenger->clearCurrentMessagesFromNamespace('info');

        return $output;
    }

    /**
     * Generates outpou of each message
     * 
     * @param array<string> $messages
     * @param string $class
     * @return string
     */
    private function createMessages($messages, $class = '')
    {
        $output = '';
        foreach ($messages as $message) {
            $output .= '<div class="alert alert-' . $class . '">';
            $output .= '<button class="close" data-dismiss="alert" type="button">x</button>';
            $output .= $message;
            $output .= '</div>';
        }

        return $output;
    }

    /**
     *
     * @return \Zend\Mvc\Controller\Plugin\FlashMessenger
     */
    public function getFlashMessenger()
    {
        return $this->flashMessenger;
    }

    /**
     *
     * @param \Zend\Mvc\Controller\Plugin\FlashMessenger $flashMessenger
     * @return \Event\View\Helper\ShowMessages
     */
    public function setFlashMessenger(\Zend\Mvc\Controller\Plugin\FlashMessenger $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
        return $this;
    }

}
