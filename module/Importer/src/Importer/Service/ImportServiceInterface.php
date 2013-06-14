<?php

namespace Importer\Service;

/**
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
interface ImportServiceInterface
{

    /**
     *
     * @param string $name
     */
    public function getPropertyByName($name);

    /**
     * @param string $path
     */
    public function parseExcel($path, $event);

    /**
     * @return \Importer\Filter\PrepareForDatabase
     */
    public function getDatabaseFilter();

    /**
     *
     * @param \Importer\Filter\PrepareForDatabase $filter
     */
    public function setDatabaseFilter(\Importer\Filter\PrepareForDatabase $filter);

    /**
     *
     * @param \Importer\Form\ImportForm $form
     */
    public function setForm(\Importer\Form\ImportForm $form);

    /**
     * @return \Importer\Form\ImportForm
     */
    public function getForm();
}