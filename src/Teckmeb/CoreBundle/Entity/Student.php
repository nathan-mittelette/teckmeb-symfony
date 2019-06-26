<?php

namespace Teckmeb\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="Teckmeb\CoreBundle\Repository\StudentRepository")
 */
class Student
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
   * @ORM\ManyToMany(targetEntity="Teckmeb\CoreBundle\Entity\Groupe", cascade={"persist"}, mappedBy="students")
   */
    private $groupes;
    
    /**
     * @var string
     *
     * @ORM\Column(name="numStudent", type="string", length=10)
     */
    private $numStudent;
    
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
     * @return Student
     */
    public function setUser(\Teckmeb\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
        $user->setRoles(array('ROLE_ETUDIANT'));
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add groupe
     *
     * @param \Teckmeb\CoreBundle\Entity\Groupe $groupe
     *
     * @return Student
     */
    public function addGroupe(\Teckmeb\CoreBundle\Entity\Groupe $groupe)
    {
        $this->groupes[] = $groupe;
        return $this;
    }

    /**
     * Remove groupe
     *
     * @param \Teckmeb\CoreBundle\Entity\Groupe $groupe
     */
    public function removeGroupe(\Teckmeb\CoreBundle\Entity\Groupe $groupe)
    {
        $this->groupes->removeElement($groupe);
    }

    /**
     * Get groupes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupes()
    {
        return $this->groupes;
    }

    /**
     * Set numStudent
     *
     * @param string $numStudent
     *
     * @return Student
     */
    public function setNumStudent($numStudent)
    {
        $this->numStudent = $numStudent;

        return $this;
    }

    /**
     * Get numStudent
     *
     * @return string
     */
    public function getNumStudent()
    {
        return $this->numStudent;
    }
    
    public function __toString()
    {
        return $this->getNumStudent() . ' ' . $this->getUser()->getSurname() . ' ' . $this->getUser()->getName();
    }

    public function getCurrentGroupe()
    {
        $list = $this->getGroupes();
        $retour = null;
        $last = null;
        foreach($list as $groupe)
        {
            if ($groupe->getSemestre()->getActive())
            {
                $retour = $groupe;
            }
            $last = $groupe;
        }
        return ($retour != null) ? $retour : $last;
    }
}
