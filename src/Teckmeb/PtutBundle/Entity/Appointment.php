<?php

namespace Teckmeb\PtutBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Appointment
 *
 * @ORM\Table(name="appointment")
 * @ORM\Entity(repositoryClass="Teckmeb\PtutBundle\Repository\AppointmentRepository")
 */
class Appointment
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

     /**
   * @ORM\ManyToOne(targetEntity="Teckmeb\PtutBundle\Entity\Ptut")
   * @ORM\JoinColumn(nullable=false)
   */
  private $ptut;

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
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Appointment
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
     * Set comment.
     *
     * @param string|null $comment
     *
     * @return Appointment
     */
    public function setComment($comment = null)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string|null
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set valide.
     *
     * @param bool $valide
     *
     * @return Appointment
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
     * Set ptut.
     *
     * @param \Teckmeb\PtutBundle\Entity\Ptut $ptut
     *
     * @return Appointment
     */
    public function setPtut(\Teckmeb\PtutBundle\Entity\Ptut $ptut)
    {
        $this->ptut = $ptut;

        return $this;
    }

    /**
     * Get ptut.
     *
     * @return \Teckmeb\PtutBundle\Entity\Ptut
     */
    public function getPtut()
    {
        return $this->ptut;
    }
}
