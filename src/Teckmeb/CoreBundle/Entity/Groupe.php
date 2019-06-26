<?php

namespace Teckmeb\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groupe
 *
 * @ORM\Table(name="groupe")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Teckmeb\CoreBundle\Repository\GroupeRepository")
 */
class Groupe
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
   * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\ChoixGroupe")
   * @ORM\JoinColumn(nullable=false)
   */
    private $groupName;

    /**
   * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Semestre", inversedBy="groupes")
   * @ORM\JoinColumn(nullable=true)
   */
    private $semestre;

    /**
   * @ORM\ManyToMany(targetEntity="Teckmeb\CoreBundle\Entity\Student", cascade={"persist"}, inversedBy="groupes")
   */
    private $students;

    /**
     * @var string
     *
     * @ORM\Column(name="groupFullName", type="string", length=4)
     */
    private $groupFullName;
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function createGroupeFullName()
    {
        if ($this->getSemestre() != null) {
            $this->setGroupFullName($this->getGroupName()->getChoixName() . $this->getSemestre()->getCourse()->getCourseType()->getName());
        } else {
            $this->setGroupFullName($this->getGroupName()->getChoixName());
        }
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
     * Set groupName
     *
     * @param string $groupName
     *
     * @return Groupe
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * Get groupName
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Set groupFullName
     *
     * @param string $groupFullName
     *
     * @return Groupe
     */
    public function setGroupFullName($groupFullName)
    {
        $this->groupFullName = $groupFullName;

        return $this;
    }

    /**
     * Get groupFullName
     *
     * @return string
     */
    public function getGroupFullName()
    {
        return $this->groupFullName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add student
     *
     * @param \Teckmeb\CoreBundle\Entity\Student $student
     *
     * @return Groupe
     */
    public function addStudent(\Teckmeb\CoreBundle\Entity\Student $student)
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->addGroupe($this);
        }
        return $this;
    }

    /**
     * Remove student
     *
     * @param \Teckmeb\CoreBundle\Entity\Student $student
     */
    public function removeStudent(\Teckmeb\CoreBundle\Entity\Student $student)
    {
        $this->students->removeElement($student);
        $student->removeGroupe($this);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Set semestre
     *
     * @param \Teckmeb\CoreBundle\Entity\Semestre $semestre
     *
     * @return Groupe
     */
    public function setSemestre(\Teckmeb\CoreBundle\Entity\Semestre $semestre = null)
    {
        $this->semestre = $semestre;

        return $this;
    }

    /**
     * Get semestre
     *
     * @return \Teckmeb\CoreBundle\Entity\Semestre
     */
    public function getSemestre()
    {
        return $this->semestre;
    }

    public function __toString()
    {
        if ($this->getSemestre() != null) {
            return $this->getGroupName()->getChoixName() . $this->getSemestre()->getCourse()->getCourseType()->getName();
        } else {
            return $this->getGroupName()->getChoixName();
        }
    }
}
