<?php

namespace Teckmeb\AdministrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Teckmeb\AdministrationBundle\Entity\TeachingUnit;

/**
 * Course
 *
 * @ORM\Table(name="course")
 * @ORM\Entity(repositoryClass="Teckmeb\AdministrationBundle\Repository\CourseRepository")
 */
class Course
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
   * @ORM\ManyToOne(targetEntity="Teckmeb\AdministrationBundle\Entity\CourseType")
   * @ORM\JoinColumn(nullable=false)
   */
    private $courseType;
    
    /**
     * @var int
     *
     * @ORM\Column(name="creationYear", type="integer")
     */
    private $creationYear;
    
    /**
   * @ORM\ManyToMany(targetEntity="Teckmeb\AdministrationBundle\Entity\TeachingUnit", cascade={"persist"})
   * @ORM\JoinTable(name="course_teaching_unit")
   */
    
    private $teachingUnits;
    
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
     * Set creationYear
     *
     * @param integer $creationYear
     *
     * @return Course
     */
    public function setCreationYear($creationYear)
    {
        $this->creationYear = $creationYear;

        return $this;
    }

    /**
     * Get creationYear
     *
     * @return int
     */
    public function getCreationYear()
    {
        return $this->creationYear;
    }

    /**
     * Set courseType
     *
     * @param \Teckmeb\AdministrationBundle\Entity\CourseType $courseType
     *
     * @return Course
     */
    public function setCourseType(\Teckmeb\AdministrationBundle\Entity\CourseType $courseType)
    {
        $this->courseType = $courseType;

        return $this;
    }

    /**
     * Get courseType
     *
     * @return \Teckmeb\AdministrationBundle\Entity\CourseType
     */
    public function getCourseType()
    {
        return $this->courseType;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $date = new \DateTime();
        $this->creationYear = $date->format('Y');
        $this->teachingUnits = new ArrayCollection();
    }

    /**
     * Add teachingUnit
     *
     * @param TeachingUnit $teachingUnit
     *
     * @return Course
     */
    public function addTeachingUnit(TeachingUnit $teachingUnit)
    {
        $this->teachingUnits[] = $teachingUnit;
        return $this;
    }

    /**
     * Remove teachingUnit
     *
     * @param TeachingUnit $teachingUnit
     */
    public function removeTeachingUnit(TeachingUnit $teachingUnit)
    {
        $this->teachingUnits->removeElement($teachingUnit);
    }

    /**
     * Get teachingUnits
     *
     * @return ArrayCollection
     */
    public function getTeachingUnits()
    {
        return $this->teachingUnits;
    }
    
    public function __toString()
    {
        return $this->getCreationYear() . ' - ' . $this->getCourseType()->getName();
    }
}
