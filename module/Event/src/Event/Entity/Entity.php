<?php

namespace Event\Entity;


use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Entity
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class Entity implements EntityInterface
{

    /**
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @Annotation\Validator({"name":"Digits"})
     * @Annotation\Required(false)
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var int
     */
    protected $id;

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param array $array
     */
    public function exchangeArray(array $array)
    {
        $filter = new \Zend\Filter\Word\UnderscoreToCamelCase();
        foreach ($array as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $method = 'set' . ucfirst($filter->filter($key));
            if (!method_exists($this, $method)) {
                continue;
            }
            $this->$method($value);
        }
    }

}
