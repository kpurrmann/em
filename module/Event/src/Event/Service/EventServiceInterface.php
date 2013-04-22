<?php

namespace Event\Service;

/**
 * Description of EventServiceInterface
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
interface EventServiceInterface
{

    public function getForm($type = 'default');

    public function setForm(\Zend\Form\Form $form, $type = 'default');
}
