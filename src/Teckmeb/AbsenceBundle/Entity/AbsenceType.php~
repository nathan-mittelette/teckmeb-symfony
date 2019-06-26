<?php

namespace Teckmeb\AbsenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbsenceType
 *
 * @ORM\Table(name="absence_type")
 * @ORM\Entity(repositoryClass="Teckmeb\AbsenceBundle\Repository\AbsenceTypeRepository")
 */
class AbsenceType
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
     * @ORM\Column(name="absenceTypeName", type="string", length=255, unique=true)
     */
    private $absenceTypeName;


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
     * Set absenceTypeName
     *
     * @param string $absenceTypeName
     *
     * @return AbsenceType
     */
    public function setAbsenceTypeName($absenceTypeName)
    {
        $this->absenceTypeName = $absenceTypeName;

        return $this;
    }

    /**
     * Get absenceTypeName
     *
     * @return string
     */
    public function getAbsenceTypeName()
    {
        return $this->absenceTypeName;
    }
}
