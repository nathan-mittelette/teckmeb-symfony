<?php

namespace Teckmeb\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promo
 *
 * @ORM\Table(name="promo")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Teckmeb\CoreBundle\Repository\PromoRepository")
 */
class Promo
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
   * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Semestre")
   * @ORM\JoinColumn(nullable=false)
   */
    private $semestre;
    
    /**
   * @ORM\ManyToOne(targetEntity="Teckmeb\CoreBundle\Entity\Subject")
   * @ORM\JoinColumn(nullable=false)
   */
    private $subject;
    
    /**
     * @var string
     *
     * @ORM\Column(name="promoName", type="string", length=255)
     */
    private $promoName;
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function createPromoName()
    {
        $this->setPromoName($this->getSemestre()->getCourse()->getCourseType()->getName() . ' - ' . $this->getSubject()->getSubjectFullName());
    }
    
    
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
     * Set promoName
     *
     * @param string $promoName
     *
     * @return Promo
     */
    public function setPromoName($promoName)
    {
        $this->promoName = $promoName;

        return $this;
    }

    /**
     * Get promoName
     *
     * @return string
     */
    public function getPromoName()
    {
        return $this->promoName;
    }

    /**
     * Set semestre
     *
     * @param \Teckmeb\CoreBundle\Entity\Semestre $semestre
     *
     * @return Promo
     */
    public function setSemestre(\Teckmeb\CoreBundle\Entity\Semestre $semestre)
    {
        $this->semestre = $semestre;

        return $this;
    }

    /**
     * Get semestre
     *
     * @return \Teckmeb\CoreBundle\Entity\Semestre
     */
    public function getSemestre()
    {
        return $this->semestre;
    }

    /**
     * Set subject
     *
     * @param \Teckmeb\CoreBundle\Entity\Subject $subject
     *
     * @return Promo
     */
    public function setSubject(\Teckmeb\CoreBundle\Entity\Subject $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \Teckmeb\CoreBundle\Entity\Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
