<?php

namespace Teckmeb\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subject
 *
 * @ORM\Table(name="subject")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Teckmeb\CoreBundle\Repository\SubjectRepository")
 */
class Subject
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
     * @ORM\Column(name="subjectCode", type="string", length=10, unique=true)
     */
    private $subjectCode;

    /**
     * @var string
     *
     * @ORM\Column(name="subjectName", type="string", length=255)
     */
    private $subjectName;

    /**
     * @var string
     *
     * @ORM\Column(name="subjectCoefficient", type="decimal", precision=10, scale=2)
     */
    private $subjectCoefficient;
    
    /**
     * @var string
     *
     * @ORM\Column(name="subjectFullName", type="string", length=255, nullable = true)
     */
    private $subjectFullName;
    
    /**
   * @ORM\ManyToMany(targetEntity="Teckmeb\CoreBundle\Entity\Teacher", cascade={"persist"}, mappedBy="subjects")
   */
    private $teachers;
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function createSubjectFullName()
    {
        $this->setSubjectFullName($this->getSubjectCode() . ' ' . $this->getSubjectName());
    }

    public function __toString()
    {
        return $this->getSubjectCode() . ' ' . $this->getSubjectName();
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
     * Set subjectCode
     *
     * @param string $subjectCode
     *
     * @return Subject
     */
    public function setSubjectCode($subjectCode)
    {
        $this->subjectCode = $subjectCode;

        return $this;
    }

    /**
     * Get subjectCode
     *
     * @return string
     */
    public function getSubjectCode()
    {
        return $this->subjectCode;
    }

    /**
     * Set subjectName
     *
     * @param string $subjectName
     *
     * @return Subject
     */
    public function setSubjectName($subjectName)
    {
        $this->subjectName = $subjectName;

        return $this;
    }

    /**
     * Get subjectName
     *
     * @return string
     */
    public function getSubjectName()
    {
        return $this->subjectName;
    }

    /**
     * Set subjectFullName
     *
     * @param string $subjectFullName
     *
     * @return Subject
     */
    public function setSubjectFullName($subjectFullName)
    {
        $this->subjectFullName = $subjectFullName;

        return $this;
    }

    /**
     * Get subjectFullName
     *
     * @return string
     */
    public function getSubjectFullName()
    {
        return $this->subjectFullName;
    }

    /**
     * Set subjectCoefficient
     *
     * @param string $subjectCoefficient
     *
     * @return Subject
     */
    public function setSubjectCoefficient($subjectCoefficient)
    {
        $this->subjectCoefficient = $subjectCoefficient;

        return $this;
    }

    /**
     * Get subjectCoefficient
     *
     * @return string
     */
    public function getSubjectCoefficient()
    {
        return $this->subjectCoefficient;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teachers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add teacher
     *
     * @param \Teckmeb\CoreBundle\Entity\Teacher $teacher
     *
     * @return Subject
     */
    public function addTeacher(\Teckmeb\CoreBundle\Entity\Teacher $teacher)
    {
        $this->teachers[] = $teacher;

        return $this;
    }

    /**
     * Remove teacher
     *
     * @param \Teckmeb\CoreBundle\Entity\Teacher $teacher
     */
    public function removeTeacher(\Teckmeb\CoreBundle\Entity\Teacher $teacher)
    {
        $this->teachers->removeElement($teacher);
    }

    /**
     * Get teachers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeachers()
    {
        return $this->teachers;
    }
}
