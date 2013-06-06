<?php

namespace Event\View\Helper;

/**
 * Description of HtmlTable
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class HtmlTable extends \Zend\View\Helper\AbstractHtmlElement implements \Event\View\Helper\HtmlTableInterface
{

    public function __invoke(\Zend\Paginator\Paginator $items, $class = 'table-striped')
    {
        $table = '';
        if (!empty($items)) {
            $table .= $this->renderHeader($items->getItem(0));
            $table .= '<tbody>';
            foreach ($items as $row) {
                $table .= $this->renderRow($row);
            }
            $table .= '</tbody>';
        } else {
            $table = '<tr><td>Keine Daten gefunden.</td></tr>';
        }

        return '<table class="table ' . $class . '">' . $table . '</table>';
    }

    /**
     *
     * @param type $item
     * @return string
     */
    public function renderRow($item)
    {
        $row = '';
        if (is_array($item)) {
            foreach ($item as $column => $value) {
                $row .= '<td>' . $value . '</td>';
            }
        } elseif ($item instanceof \Event\Entity\EventInterface) {
            $row .= '<td>' . $item->getId() . '</td>';
            $row .= '<td>' . $item->getTitle() . '</td>';
            $row .= '<td>' . $item->getEventDate() . '</td>';
            $row .= '<td class="controls">
                        <div class="btn-group">
                            <a class="btn" href="' . $this->getView()->url('events/action', array('action' => 'show', 'id' => $item->getId())) . '"><i class="icon-info-sign"></i></a>
                            <a class="btn" href="' . $this->getView()->url('events/action', array('action' => 'edit', 'id' => $item->getId())) . '"><i class="icon-edit"></i></a>
                            <a class="btn btn-danger" href="' . $this->getView()->url('events/action', array('action' => 'delete', 'id' => $item->getId())) . '"><i class="icon-trash"></i></a>
                        </div>
                    </td>';
        } elseif ($item instanceof \Event\Entity\EventsGuests) {
            $row .= '<td>' . $item->getGuest()->getId() . '</td>';
            $row .= '<td>' . $item->getGuest()->getPrename() . ' ' . $item->getGuest()->getLastname() . '</td>';
            $row .= '<td>' . $item->getGuest()->getEmail() . '</td>';
            $row .= '<td>' . $this->getView()->confirmation($item->getConfirmation()) . '</td>';
        }

        return '<tr>' . $row . '</tr>';
    }

    public function renderHeader($item)
    {
        $head = '';
        if (is_object($item) && $item instanceof \Event\Entity\EventInterface) {
            $head .= '<tr><th> Nr. </th> <th> Titel</th><th>Datum</th>';
            $head .= '<th class="controls"><a class="btn btn-success" href="' . $this->getView()->url('events/action', array('action' => 'edit')) . '"><i class="icon-plus"></i></a></th>';
        }

        if (is_object($item) && $item instanceof \Event\Entity\EventsGuests) {
            $head .= '<tr><th> Nr. </th><th>Name</th><th>E-Mail</th><th>Zusage</th>';
        }

        return '<thead>' . $head . '</thead>';
    }

}
