<?php

namespace Event\View\Helper;

/**
 * Description of Confirmation
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class Confirmation extends \Zend\View\Helper\AbstractHelper
{

    /**
     *
     * @param int $confirmation
     * @return string
     */
    public function __invoke($confirmation)
    {
        switch ($confirmation) {
            case 1:
                $label = 'Zusage';
                break;
            default:
                $label = 'keine Zusage';
                break;
        }

        return $label;
    }

}
