<?php

namespace Teckmeb\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Education
 *
 * @ORM\Table(name="education")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Teckmeb\CoreBundle\Repository\EducationRepository")
 */
class Education
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
   * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Groupe")
   * @ORM\JoinColumn(nullable=false)
   */
    private $groupe;
    
    /**
   * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Teacher")
   * @ORM\JoinColumn(nullable=false)
   */
    private $teacher;
    
    /**
   * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Subject", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
    private $subject;
    
    /**
     * @var string
     *
     * @ORM\Column(name="educationName", type="string", length=255)
     */
    private $educationName;
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function createEducationName()
    {
        $this->setEducationName($this->getGroupe()->getGroupFullName() . ' - ' . $this->getSubject()->getSubjectName());
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
     * Set groupe
     *
     * @param \Teckmeb\CoreBundle\Entity\Groupe $groupe
     *
     * @return Education
     */
    public function setGroupe(\Teckmeb\CoreBundle\Entity\Groupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \Teckmeb\CoreBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set teacher
     *
     * @param \Teckmeb\CoreBundle\Entity\Teacher $teacher
     *
     * @return Education
     */
    public function setTeacher(\Teckmeb\CoreBundle\Entity\Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \Teckmeb\CoreBundle\Entity\Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set subject
     *
     * @param \Teckmeb\CoreBundle\Entity\Subject $subject
     *
     * @return Education
     */
    public function setSubject(\Teckmeb\CoreBundle\Entity\Subject $subject = null)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Get subject
     *
     * @return \Teckmeb\CoreBundle\Entity\Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set educationName
     *
     * @param string $educationName
     *
     * @return Education
     */
    public function setEducationName($educationName)
    {
        $this->educationName = $educationName;

        return $this;
    }

    /**
     * Get educationName
     *
     * @return string
     */
    public function getEducationName()
    {
        return $this->educationName;
    }
}
