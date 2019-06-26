<?php

namespace Teckmeb\AbsenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Absence
 *
 * @ORM\Table(name="absence")
 * @ORM\Entity(repositoryClass="Teckmeb\AbsenceBundle\Repository\AbsenceRepository")
 */
class Absence
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
     * @ORM\Column(name="beginDate", type="datetime")
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime")
     */
    private $endDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="justified", type="boolean")
     */
    private $justified;

    /**
     * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Groupe")
     * @ORM\JoinColumn(nullable=false)
     */
     private $groupe;
    
    /**
     * @ORM\ManyToOne(targetEntity="Teckmeb\AbsenceBundle\Entity\AbsenceType")
     * @ORM\JoinColumn(nullable=false)
     */
     private $absenceType;
    
    /**
     * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Student")
     * @ORM\JoinColumn(nullable=false)
     */
     private $student;
    
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
     * Set beginDate
     *
     * @param \DateTime $beginDate
     *
     * @return Absence
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * Get beginDate
     *
     * @return \DateTime
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Absence
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set justified
     *
     * @param boolean $justified
     *
     * @return Absence
     */
    public function setJustified($justified)
    {
        $this->justified = $justified;

        return $this;
    }

    /**
     * Get justified
     *
     * @return bool
     */
    public function getJustified()
    {
        return $this->justified;
    }

    /**
     * Set groupe
     *
     * @param \Teckmeb\CoreBundle\Entity\Groupe $groupe
     *
     * @return Absence
     */
    public function setGroupe(\Teckmeb\CoreBundle\Entity\Groupe $groupe)
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
     * Set absenceType
     *
     * @param \Teckmeb\AbsenceBundle\Entity\AbsenceType $absenceType
     *
     * @return Absence
     */
    public function setAbsenceType(\Teckmeb\AbsenceBundle\Entity\AbsenceType $absenceType)
    {
        $this->absenceType = $absenceType;

        return $this;
    }

    /**
     * Get absenceType
     *
     * @return \Teckmeb\AbsenceBundle\Entity\AbsenceType
     */
    public function getAbsenceType()
    {
        return $this->absenceType;
    }

    /**
     * Set student
     *
     * @param \Teckmeb\CoreBundle\Entity\Student $student
     *
     * @return Absence
     */
    public function setStudent(\Teckmeb\CoreBundle\Entity\Student $student)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \Teckmeb\CoreBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }
    
    public function __construct()
    {
        $date = new \DateTime();
        $this->beginDate = $date;
        $this->endDate = $date;
    }
}
