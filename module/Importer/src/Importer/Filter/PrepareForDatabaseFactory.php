<?php

namespace Importer\Filter;

/**
 * Description of PrepareForDatabase
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class PrepareForDatabaseFactory
{

    /**
     *
     * @var PrepareForDatabase
     */
    protected $filter;

    /**
     * 
     */
    public function __construct()
    {
        $chain = new \Zend\Filter\FilterChain();
        $chain->attachByName('StringTrim')
           ->attachByName('Word\DashToUnderscore')
           ->attachByName('Word\UnderscoreToCamelCase')
           ->attachByName('StringToLower');
        $this->filter = new PrepareForDatabase($chain);
    }

    /**
     *
     * @return PrepareForDatabase
     */
    public function getFilter()
    {
        return $this->filter;
    }

}
