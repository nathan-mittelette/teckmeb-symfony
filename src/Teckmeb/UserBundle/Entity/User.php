<?php

namespace Teckmeb\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Teckmeb\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    protected $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="name_canonical", type="string", length=255)
     */
    protected $name_canonical;

    /**
     * @var string
     *
     * @ORM\Column(name="surname_canonical", type="string", length=255)
     */
    protected $surname_canonical;

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
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->setNameCanonical($this->skip_accents($this->getName()));
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        $this->setSurnameCanonical($this->skip_accents($this->getSurname()));
        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set nameCanonical.
     *
     * @param string $nameCanonical
     *
     * @return User
     */
    public function setNameCanonical($nameCanonical)
    {
        $this->name_canonical = $nameCanonical;

        return $this;
    }

    /**
     * Get nameCanonical.
     *
     * @return string
     */
    public function getNameCanonical()
    {
        return $this->name_canonical;
    }

    /**
     * Set surnameCanonical.
     *
     * @param string $surnameCanonical
     *
     * @return User
     */
    public function setSurnameCanonical($surnameCanonical)
    {
        $this->surname_canonical = $surnameCanonical;

        return $this;
    }

    /**
     * Get surnameCanonical.
     *
     * @return string
     */
    public function getSurnameCanonical()
    {
        return $this->surname_canonical;
    }


    private function skip_accents($str, $charset = 'utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        $str = preg_replace('#&[^;]+;#', '', $str);
        return strtolower($str);
    }
}
