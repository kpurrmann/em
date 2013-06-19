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

            $request = $this->getRequest();

            if ($request->isPost()) {
                $post = array_merge_recursive(
                   $request->getPost()->toArray(), $request->getFiles()->toArray()
                );

                $form->setData($post);

                if ($form->isValid()) {
                    if (!empty($post['isAjax'])) {
                        $data = $form->getData();
                        $this->importService->parseExcel($data['file']['tmp_name'], $data['event']);
                        unlink($data['file']['tmp_name']);
                        $model = new \Zend\View\Model\JsonModel();
                        $model->setTerminal(true);
                        $model->setVariables(array(
                           'status' => true,
                           'redirect' => $this->url()->fromRoute('events/action', array('action' => 'show', 'id' => $data['event'])),
                           'formData' => $data,
                        ));
                        return $model;
                    }
                } else {
                    $this->importService->getFlashMessenger()->addErrorMessage('Es ist ein Fehler augetreten.');
                    if (!empty($post['isAjax'])) {
                        $model = new \Zend\View\Model\JsonModel();
                        $model->setTerminal(true);
                        return $model->setVariables(array(
                              'status' => false,
                              'messages' => $form->getMessages()
                           ));
                    }
                }
            }

            $form->get('event')->setValue($id);
            return $viewModel->setVariables(array('form' => $form, 'id' => $id));
        }
    }

    /**
     * @todo Maybe better to outsource this part cause of bootstrapping
     * @return \Zend\View\Model\JsonModel
     */
    public function progressAction()
    {
        $model = new \Zend\View\Model\JsonModel();
        $model->setTerminal(true);
        $id = $this->params()->fromQuery('id', null);
        $progress = new \Zend\ProgressBar\Upload\SessionProgress();
        return $model->setVariables($progress->getProgress($id));
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
