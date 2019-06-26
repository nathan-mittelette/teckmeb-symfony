<?php

namespace Teckmeb\ControlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ControlType
 *
 * @ORM\Table(name="control_type")
 * @ORM\Entity(repositoryClass="Teckmeb\ControlBundle\Repository\ControlTypeRepository")
 */
class ControlType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="controlTypeName", type="string", length=255)
     */
    private $controlTypeName;

    public function __toString()
    {
        return $this->getControlTypeName();
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set controlTypeName
     *
     * @param string $controlTypeName
     *
     * @return ControlType
     */
    public function setControlTypeName($controlTypeName)
    {
        $this->controlTypeName = $controlTypeName;

        return $this;
    }

    /**
     * Get controlTypeName
     *
     * @return string
     */
    public function getControlTypeName()
    {
        return $this->controlTypeName;
    }
}
