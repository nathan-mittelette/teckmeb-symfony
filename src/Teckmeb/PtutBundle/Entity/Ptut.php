<?php

namespace Teckmeb\PtutBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ptut
 *
 * @ORM\Table(name="ptut")
 * @ORM\Entity(repositoryClass="Teckmeb\PtutBundle\Repository\PtutRepository")
 */
class Ptut
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
   * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Teacher")
   * @ORM\JoinColumn(nullable=false)
   */
  private $teacher;

  /**
   * @ORM\ManyToMany(targetEntity="Teckmeb\CoreBundle\Entity\Student", cascade={"persist"}, inversedBy="groupes")
   */
  private $students;

  /**
     * @var boolean
     *
     * @ORM\Column(name="valide", type="boolean", options={"default":false})
     */
    private $valide;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Ptut
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set teacher.
     *
     * @param \Teckmeb\CoreBundle\Entity\Teacher $teacher
     *
     * @return Ptut
     */
    public function setTeacher(\Teckmeb\CoreBundle\Entity\Teacher $teacher)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher.
     *
     * @return \Teckmeb\CoreBundle\Entity\Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Add student.
     *
     * @param \Teckmeb\CoreBundle\Entity\Student $student
     *
     * @return Ptut
     */
    public function addStudent(\Teckmeb\CoreBundle\Entity\Student $student)
    {
        $this->students[] = $student;

        return $this;
    }

    /**
     * Remove student.
     *
     * @param \Teckmeb\CoreBundle\Entity\Student $student
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeStudent(\Teckmeb\CoreBundle\Entity\Student $student)
    {
        return $this->students->removeElement($student);
    }

    /**
     * Get students.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Set valide.
     *
     * @param bool $valide
     *
     * @return Ptut
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Get valide.
     *
     * @return bool
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Ptut
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
