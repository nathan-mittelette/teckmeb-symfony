<?php

namespace Teckmeb\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secretariat
 *
 * @ORM\Table(name="secretariat")
 * @ORM\Entity(repositoryClass="Teckmeb\CoreBundle\Repository\SecretariatRepository")
 */
class Secretariat
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
     * @return Secretariat
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
