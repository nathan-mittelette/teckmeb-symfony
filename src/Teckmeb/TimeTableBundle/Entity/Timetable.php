<?php

namespace Teckmeb\TimeTableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Timetable
 *
 * @ORM\Table(name="timetable")
 * @ORM\Entity(repositoryClass="Teckmeb\TimeTableBundle\Repository\TimetableRepository")
 */
class Timetable
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
     * @var int
     *
     * @ORM\Column(name="resource", type="integer")
     */
    private $resource;
    
    /**
      * @ORM\ManyToOne(targetEntity="Teckmeb\UserBundle\Entity\User")
      * @ORM\JoinColumn(nullable=true)
      */
    private $user;

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
     * Set resource
     *
     * @param integer $resource
     *
     * @return Timetable
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return int
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set user
     *
     * @param \Teckmeb\UserBundle\Entity\User $user
     *
     * @return Timetable
     */
    public function setUser(\Teckmeb\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

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
}
