<?php

namespace Teckmeb\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChoixGroupe
 *
 * @ORM\Table(name="choix_groupe")
 * @ORM\Entity(repositoryClass="Teckmeb\CoreBundle\Repository\ChoixGroupeRepository")
 */
class ChoixGroupe
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
     * @ORM\Column(name="choixName", type="string", length=3, unique=true)
     */
    private $choixName;

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
     * Set choixName
     *
     * @param string $choixName
     *
     * @return ChoixGroupe
     */
    public function setChoixName($choixName)
    {
        $this->choixName = $choixName;

        return $this;
    }

    /**
     * Get choixName
     *
     * @return string
     */
    public function getChoixName()
    {
        return $this->choixName;
    }
}
