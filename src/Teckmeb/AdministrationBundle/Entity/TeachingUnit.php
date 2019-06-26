<?php

namespace Teckmeb\AdministrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TeachingUnit
 *
 * @ORM\Table(name="teaching_unit")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Teckmeb\AdministrationBundle\Repository\TeachingUnitRepository")
 */
class TeachingUnit
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
     * @ORM\Column(name="teachingUnitCode", type="string", length=4)
     */
    private $teachingUnitCode;

    /**
     * @var string
     *
     * @ORM\Column(name="teachingUnitName", type="string", length=255)
     */
    private $teachingUnitName;

    /**
     * @var int
     *
     * @ORM\Column(name="creationYear", type="integer")
     */
    private $creationYear;

    /**
     * @var string
     *
     * @ORM\Column(name="teachingUnitFullName", type="string", length=255)
     */
    private $teachingUnitFullName;
    
    /**
   * @ORM\ManyToMany(targetEntity="Teckmeb\AdministrationBundle\Entity\Module", cascade={"persist"})
   */
    private $modules;
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function createTeachingUnitFullName()
    {
        $this->setTeachingUnitFullName($this->getCreationYear() . ' ' . $this->getTeachingUnitCode() . ' - ' . $this->getTeachingUnitName());
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
     * Set teachingUnitCode
     *
     * @param string $teachingUnitCode
     *
     * @return TeachingUnit
     */
    public function setTeachingUnitCode($teachingUnitCode)
    {
        $this->teachingUnitCode = $teachingUnitCode;

        return $this;
    }

    /**
     * Get teachingUnitCode
     *
     * @return string
     */
    public function getTeachingUnitCode()
    {
        return $this->teachingUnitCode;
    }

    /**
     * Set teachingUnitName
     *
     * @param string $teachingUnitName
     *
     * @return TeachingUnit
     */
    public function setTeachingUnitName($teachingUnitName)
    {
        $this->teachingUnitName = $teachingUnitName;

        return $this;
    }

    /**
     * Get teachingUnitName
     *
     * @return string
     */
    public function getTeachingUnitName()
    {
        return $this->teachingUnitName;
    }

    /**
     * Set creationYear
     *
     * @param integer $creationYear
     *
     * @return TeachingUnit
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
     * Set teachingUnitFullName
     *
     * @param string $teachingUnitFullName
     *
     * @return TeachingUnit
     */
    public function setTeachingUnitFullName($teachingUnitFullName)
    {
        $this->teachingUnitFullName = $teachingUnitFullName;

        return $this;
    }

    /**
     * Get teachingUnitFullName
     *
     * @return string
     */
    public function getTeachingUnitFullName()
    {
        return $this->teachingUnitFullName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modules = new \Doctrine\Common\Collections\ArrayCollection();
        $date = new \DateTime();
        $this->creationYear = $date->format('Y');
    }

    /**
     * Add module
     *
     * @param \Teckmeb\AdministrationBundle\Entity\Module $module
     *
     * @return TeachingUnit
     */
    public function addModule(\Teckmeb\AdministrationBundle\Entity\Module $module)
    {
        $this->modules[] = $module;

        return $this;
    }

    /**
     * Remove module
     *
     * @param \Teckmeb\AdministrationBundle\Entity\Module $module
     */
    public function removeModule(\Teckmeb\AdministrationBundle\Entity\Module $module)
    {
        $this->modules->removeElement($module);
    }

    /**
     * Get modules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModules()
    {
        return $this->modules;
    }
}
