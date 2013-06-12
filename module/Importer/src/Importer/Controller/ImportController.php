<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Importer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ImportController extends AbstractActionController
{

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {

        $excel = \PHPExcel_IOFactory::createReaderForFile('/var/www/em/data/uploads/test.xml');
        /* @var $sheet \PHPExcel */
        $sheet = $excel->load('/var/www/em/data/uploads/test.xml');

        /* @var $active \PHPExcel_Worksheet */
        $active = $sheet->getActiveSheet();

        /* @var $row \PHPExcel_Worksheet_Row */
        /* @var $cell \PHPExcel_Cell */
        foreach ($active->getRowIterator(2) as $row) {
            foreach ($row->getCellIterator() as $cell) {
                if (!is_float($cell->getValue())) {
                    \Zend\Debug\Debug::dump($cell->getValue());
                }
            }
        }
        exit;

        return new ViewModel(array(
              'events' => 'TEST'
           ));
    }

}
