<?php

namespace Teckmeb\QuestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="Teckmeb\QuestionBundle\Repository\AnswerRepository")
 */
class Answer
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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
      * @ORM\ManyToOne(targetEntity="Teckmeb\UserBundle\Entity\User")
      * @ORM\JoinColumn(nullable=false)
      */
    private $user;

    /**
      * @ORM\ManyToOne(targetEntity="Teckmeb\QuestionBundle\Entity\Question")
      * @ORM\JoinColumn(nullable=false)
      */
      private $question;

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
     * Set content.
     *
     * @param string $content
     *
     * @return Answer
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
     * @return Answer
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
     * Set user.
     *
     * @param \Teckmeb\UserBundle\Entity\User $user
     *
     * @return Answer
     */
    public function setUser(\Teckmeb\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Teckmeb\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * Set question.
     *
     * @param \Teckmeb\QuestionBundle\Entity\Question $question
     *
     * @return Answer
     */
    public function setQuestion(\Teckmeb\QuestionBundle\Entity\Question $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question.
     *
     * @return \Teckmeb\QuestionBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
