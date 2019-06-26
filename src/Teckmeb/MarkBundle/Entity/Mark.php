<?php

namespace Teckmeb\MarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mark
 *
 * @ORM\Table(name="mark")
 * @ORM\Entity(repositoryClass="Teckmeb\MarkBundle\Repository\MarkRepository")
 */
class Mark
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
     * @ORM\Column(name="value", type="decimal", precision=4, scale=2)
     */
    private $value;

    /**
   * @ORM\ManyToOne(targetEntity="Teckmeb\ControlBundle\Entity\Control")
   * @ORM\JoinColumn(nullable=false)
   */
    private $control;
    
    /**
   * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Student")
   * @ORM\JoinColumn(nullable=false)
   */
    private $student;
    
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
     * Set value
     *
     * @param string $value
     *
     * @return Mark
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set control
     *
     * @param \Teckmeb\ControlBundle\Entity\Control $control
     *
     * @return Mark
     */
    public function setControl(\Teckmeb\ControlBundle\Entity\Control $control)
    {
        $this->control = $control;

        return $this;
    }

    /**
     * Get control
     *
     * @return \Teckmeb\ControlBundle\Entity\Control
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * Set student
     *
     * @param \Teckmeb\CoreBundle\Entity\Student $student
     *
     * @return Mark
     */
    public function setStudent(\Teckmeb\CoreBundle\Entity\Student $student)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \Teckmeb\CoreBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }
}
