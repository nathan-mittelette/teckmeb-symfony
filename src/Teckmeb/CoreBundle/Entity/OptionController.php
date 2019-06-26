<?php

namespace Teckmeb\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OptionController
 *
 * @ORM\Table(name="option_controller")
 * @ORM\Entity(repositoryClass="Teckmeb\CoreBundle\Repository\OptionControllerRepository")
 */
class OptionController
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
     * @ORM\Column(name="nomOption", type="string", length=255)
     */
    private $nomOption;

    /**
     * @var string
     *
     * @ORM\Column(name="tips", type="string", length=255)
     */
    private $tips;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Controller")
     * @ORM\JoinColumn(nullable=false)
     */
    private $controller;


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
     * Set nomOption.
     *
     * @param string $nomOption
     *
     * @return OptionController
     */
    public function setNomOption($nomOption)
    {
        $this->nomOption = $nomOption;

        return $this;
    }

    /**
     * Get nomOption.
     *
     * @return string
     */
    public function getNomOption()
    {
        return $this->nomOption;
    }

    /**
     * Set value.
     *
     * @param string $value
     *
     * @return OptionController
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set controller.
     *
     * @param \Teckmeb\CoreBundle\Entity\Controller $controller
     *
     * @return OptionController
     */
    public function setController(\Teckmeb\CoreBundle\Entity\Controller $controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Get controller.
     *
     * @return \Teckmeb\CoreBundle\Entity\Controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Set tips.
     *
     * @param string $tips
     *
     * @return OptionController
     */
    public function setTips($tips)
    {
        $this->tips = $tips;

        return $this;
    }

    /**
     * Get tips.
     *
     * @return string
     */
    public function getTips()
    {
        return $this->tips;
    }
}
