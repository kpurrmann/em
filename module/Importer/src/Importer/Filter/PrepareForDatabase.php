<?php

namespace Importer\Filter;

/**
 * Description of PrepareForDatabase
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class PrepareForDatabase extends \Zend\Filter\AbstractFilter
{

    protected $chain;

    public function __construct(\Zend\Filter\FilterChain $chain)
    {
        $this->chain = $chain;
    }

    public function filter($value)
    {
        return $this->chain->filter($value);
    }

}
