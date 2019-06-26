<?php

namespace Teckmeb\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teacher
 *
 * @ORM\Table(name="teacher")
 * @ORM\Entity(repositoryClass="Teckmeb\CoreBundle\Repository\TeacherRepository")
 */
class Teacher
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
      * @ORM\OneToOne(targetEntity="Teckmeb\UserBundle\Entity\User", cascade={"persist"})
      */
    private $user;
    
    /**
   * @ORM\ManyToMany(targetEntity="Teckmeb\CoreBundle\Entity\Subject", cascade={"persist"}, inversedBy="teachers")
   */
    private $subjects;
    
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
     * Set user
     *
     * @param \Teckmeb\UserBundle\Entity\User $user
     *
     * @return Teacher
     */
    public function setUser(\Teckmeb\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
        $user->setRoles(array('ROLE_TEACHER'));
        return $this;
    }

    /**
     * Get user
     *
     * @return \Teckmeb\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subjects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add subject
     *
     * @param \Teckmeb\CoreBundle\Entity\Subject $subject
     *
     * @return Teacher
     */
    public function addSubject(\Teckmeb\CoreBundle\Entity\Subject $subject)
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects[] = $subject;
            $subject->addTeacher($this);
        }
        return $this;
    }

    /**
     * Remove subject
     *
     * @param \Teckmeb\CoreBundle\Entity\Subject $subject
     */
    public function removeSubject(\Teckmeb\CoreBundle\Entity\Subject $subject)
    {
        $this->subjects->removeElement($subject);
        $subject->removeTeacher($this);
    }

    /**
     * Get subjects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    public function __toString()
    {
        $name = $this->getUser()->getName();
        $name = strtolower($name);
        $name = ucfirst($name);
        $surname = $this->getUser()->getSurname();
        $surname = strtolower($surname);
        $surname = ucfirst($surname);
        return $name . " " . $surname;
    }
}
