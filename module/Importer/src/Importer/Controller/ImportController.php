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
     * @var \Importer\Service\ImportServiceInterface
     */
    protected $importService;

    /**
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {

        $form = $this->importService->getForm();
        if ($id = $this->params('id')) {

            $viewModel = new ViewModel();
            if ($this->getRequest()->isXmlHttpRequest()) {
                $viewModel->setTerminal(true);
            }

            $prg = $this->fileprg($form);
            if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
                return $prg; // Return PRG redirect response
            } elseif (is_array($prg)) {
                if ($form->isValid()) {
                    $data = $form->getData();
                    $this->importService->parseExcel($data['file']['tmp_name'], $data['event']);
                    unlink($data['file']['tmp_name']);
                    return $this->redirect()->toRoute('events/action', array('action' => 'show', 'id' => $data['event']));
                } else {
                    $this->importService->getFlashMessenger()->addErrorMessage('Es ist ein Fehler augetreten.');
                }
            }

            $form->get('event')->setValue($id);
            return $viewModel->setVariables(array('form' => $form, 'id' => $id));
        }
    }

    /**
     *
     * @return \Importer\Service\ImportServiceInterface
     */
    public function getImportService()
    {
        return $this->importService;
    }

    /**
     *
     * @param \Importer\Service\ImportServiceInterface $importService
     */
    public function setImportService($importService)
    {
        $this->importService = $importService;
    }

}
