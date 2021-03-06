<?php

namespace Teckmeb\CoreBundle\Repository;

/**
 * EducationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EducationRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function getEducationTeacher($teacher)
    {
        $now = new \DateTime();
        return $this
            ->createQueryBuilder('e')
            ->join('e.groupe', 'g','with' ,'e.groupe = g')
            ->join('g.semestre', 's','with' ,'g.semestre = s')
            ->where('e.teacher = :teacher')
            ->andWhere(':date between s.beginDate and s.endDate')
            ->setParameter('teacher', $teacher)
            ->setParameter('date', $now);
    }
    
    public function myFindEducation($subject, $groupe)
    {
        $query = $this->_em->createQuery('select e from TeckmebCoreBundle:Education e where e.groupe = :groupe and e.subject = :subject');
        $query->setParameter('subject', $subject);
        $query->setParameter('groupe', $groupe);
        return $query->getResult();
    }

    public function myVerification($control, $teacher)
    {
        $query = $this->_em->createQuery('select e from TeckmebCoreBundle:Education e, TeckmebCoreBundle:Groupe g where e.groupe = g and e.subject = :subject and e.teacher = :teacher and g.semestre = :semestre');
        $query->setParameter('subject', $control->getPromo()->getSubject());
        $query->setParameter('semestre', $control->getPromo()->getSemestre());
        $query->setParameter('teacher', $teacher);
        return $query->getResult();
    }
}
