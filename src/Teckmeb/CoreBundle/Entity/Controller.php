<?php

namespace Teckmeb\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Controller
 *
 * @ORM\Table(name="controller")
 * @ORM\Entity(repositoryClass="Teckmeb\CoreBundle\Repository\ControllerRepository")
 */
class Controller
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
     * @ORM\Column(name="nomBundle", type="string", length=255, unique=false)
     */
    private $nomBundle;

    /**
     * @var string
     *
     * @ORM\Column(name="nomRoute", type="string", length=255, unique=false)
     */
    private $nomRoute;

    /**
     * @var string
     *
     * @ORM\Column(name="nomNavbar", type="string", length=255)
     */
    private $nomNavbar;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="nomController", type="string", length=255, unique=true)
     */
    private $nomController;

    /**
     * @var bool
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide;

    /**
     * @var bool
     *
     * @ORM\Column(name="alterable", type="boolean")
     */
    private $alterable;

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
     * Set valide
     *
     * @param boolean $valide
     *
     * @return Controller
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Get valide
     *
     * @return bool
     */
    public function getValide()
    {
        return $this->valide;
    }

    public function __construct()
    {
        $this->valide = false;
    }

    /**
     * Set nomBundle.
     *
     * @param string $nomBundle
     *
     * @return Controller
     */
    public function setNomBundle($nomBundle)
    {
        $this->nomBundle = $nomBundle;

        return $this;
    }

    /**
     * Get nomBundle.
     *
     * @return string
     */
    public function getNomBundle()
    {
        return $this->nomBundle;
    }

    /**
     * Set nomController.
     *
     * @param string $nomController
     *
     * @return Controller
     */
    public function setNomController($nomController)
    {
        $this->nomController = $nomController;

        return $this;
    }

    /**
     * Get nomController.
     *
     * @return string
     */
    public function getNomController()
    {
        return $this->nomController;
    }

    /**
     * Set nomRoute.
     *
     * @param string $nomRoute
     *
     * @return Controller
     */
    public function setNomRoute($nomRoute)
    {
        $this->nomRoute = $nomRoute;

        return $this;
    }

    /**
     * Get nomRoute.
     *
     * @return string
     */
    public function getNomRoute()
    {
        return $this->nomRoute;
    }

    /**
     * Set nomNavbar.
     *
     * @param string $nomNavbar
     *
     * @return Controller
     */
    public function setNomNavbar($nomNavbar)
    {
        $this->nomNavbar = $nomNavbar;

        return $this;
    }

    /**
     * Get nomNavbar.
     *
     * @return string
     */
    public function getNomNavbar()
    {
        return $this->nomNavbar;
    }

    /**
     * Set roles.
     *
     * @param array $roles
     *
     * @return Controller
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set alterable.
     *
     * @param bool $alterable
     *
     * @return Controller
     */
    public function setAlterable($alterable)
    {
        $this->alterable = $alterable;

        return $this;
    }

    /**
     * Get alterable.
     *
     * @return bool
     */
    public function getAlterable()
    {
        return $this->alterable;
    }
}
