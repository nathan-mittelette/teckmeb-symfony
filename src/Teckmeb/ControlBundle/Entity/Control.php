<?php

namespace Teckmeb\ControlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Control
 *
 * @ORM\Table(name="control")
 * @ORM\Entity(repositoryClass="Teckmeb\ControlBundle\Repository\ControlRepository")
 */
class Control
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
      * @ORM\ManyToOne(targetEntity="Teckmeb\ControlBundle\Entity\ControlType")
      * @ORM\JoinColumn(nullable=false)
      */
     private $controlType;
    
    /**
     * @var string
     *
     * @ORM\Column(name="controlName", type="string", length=255)
     */
    private $controlName;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="coefficient", type="decimal", precision=10, scale=0)
     */
    private $coefficient;

    /**
     * @var string
     *
     * @ORM\Column(name="divisor", type="decimal", precision=10, scale=0)
     */
    private $divisor;

    /**
     * @var string
     *
     * @ORM\Column(name="median", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $median;

    /**
     * @var string
     *
     * @ORM\Column(name="average", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $average;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="controlDate", type="date")
     */
    private $controlDate;
    
    /**
      * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Education")
      * @ORM\JoinColumn(nullable=true)
      */
    private $education;
    
    /**
      * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Promo")
      * @ORM\JoinColumn(nullable=true)
      */
    private $promo;
     
    public function __construct ()
    {
        $this->controlDate = new \Datetime();
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
     * Set controlName
     *
     * @param string $controlName
     *
     * @return Control
     */
    public function setControlName($controlName)
    {
        $this->controlName = $controlName;

        return $this;
    }

    /**
     * Get controlName
     *
     * @return string
     */
    public function getControlName()
    {
        return $this->controlName;
    }

    /**
     * Set coefficient
     *
     * @param string $coefficient
     *
     * @return Control
     */
    public function setCoefficient($coefficient)
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    /**
     * Get coefficient
     *
     * @return string
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * Set divisor
     *
     * @param string $divisor
     *
     * @return Control
     */
    public function setDivisor($divisor)
    {
        $this->divisor = $divisor;

        return $this;
    }

    /**
     * Get divisor
     *
     * @return string
     */
    public function getDivisor()
    {
        return $this->divisor;
    }

    /**
     * Set median
     *
     * @param string $median
     *
     * @return Control
     */
    public function setMedian($median)
    {
        $this->median = $median;

        return $this;
    }

    /**
     * Get median
     *
     * @return string
     */
    public function getMedian()
    {
        return $this->median;
    }

    /**
     * Set average
     *
     * @param string $average
     *
     * @return Control
     */
    public function setAverage($average)
    {
        $this->average = $average;

        return $this;
    }

    /**
     * Get average
     *
     * @return string
     */
    public function getAverage()
    {
        return $this->average;
    }

    /**
     * Set controlDate
     *
     * @param \DateTime $controlDate
     *
     * @return Control
     */
    public function setControlDate($controlDate)
    {
        $this->controlDate = $controlDate;

        return $this;
    }

    /**
     * Get controlDate
     *
     * @return \DateTime
     */
    public function getControlDate()
    {
        return $this->controlDate;
    }

    /**
     * Set controlType
     *
     * @param \Teckmeb\ControlBundle\Entity\ControlType $controlType
     *
     * @return Control
     */
    public function setControlType(\Teckmeb\ControlBundle\Entity\ControlType $controlType)
    {
        $this->controlType = $controlType;

        return $this;
    }

    /**
     * Get controlType
     *
     * @return \Teckmeb\ControlBundle\Entity\ControlType
     */
    public function getControlType()
    {
        return $this->controlType;
    }

    /**
     * Set education
     *
     * @param \Teckmeb\CoreBundle\Entity\Education $education
     *
     * @return Control
     */
    public function setEducation(\Teckmeb\CoreBundle\Entity\Education $education)
    {
        $this->education = $education;

        return $this;
    }

    /**
     * Get education
     *
     * @return \Teckmeb\CoreBundle\Entity\Education
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set promo
     *
     * @param \Teckmeb\CoreBundle\Entity\Promo $promo
     *
     * @return Control
     */
    public function setPromo(\Teckmeb\CoreBundle\Entity\Promo $promo = null)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo
     *
     * @return \Teckmeb\CoreBundle\Entity\Promo
     */
    public function getPromo()
    {
        return $this->promo;
    }
}
