<?php

namespace Teckmeb\QuestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="Teckmeb\QuestionBundle\Repository\QuestionRepository")
 */
class Question
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="public", type="boolean")
     */
    private $public;
    
    /**
      * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Student")
      * @ORM\JoinColumn(nullable=false)
      */
    private $student;
    
    /**
      * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Teacher")
      * @ORM\JoinColumn(nullable=false)
      */
    private $teacher;
    
    /**
      * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Groupe")
      * @ORM\JoinColumn(nullable=false)
      */
    private $groupe;

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
     * Set title.
     *
     * @param string $title
     *
     * @return Question
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Question
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Question
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set public.
     *
     * @param bool $public
     *
     * @return Question
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public.
     *
     * @return bool
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set student.
     *
     * @param \Teckmeb\CoreBundle\Entity\Student $student
     *
     * @return Question
     */
    public function setStudent(\Teckmeb\CoreBundle\Entity\Student $student)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student.
     *
     * @return \Teckmeb\CoreBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set teacher.
     *
     * @param \Teckmeb\CoreBundle\Entity\Teacher $teacher
     *
     * @return Question
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
    
    public function __construct()
    {
        $this->date = new \DateTime();
        $this->public = false;
    }

    /**
     * Set groupe.
     *
     * @param \Teckmeb\CoreBundle\Entity\Groupe $groupe
     *
     * @return Question
     */
    public function setGroupe(\Teckmeb\CoreBundle\Entity\Groupe $groupe)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe.
     *
     * @return \Teckmeb\CoreBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }
}
