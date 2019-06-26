<?php

namespace Teckmeb\MarkBundle\Repository;

/**
 * MarkRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MarkRepository extends \Doctrine\ORM\EntityRepository
{

    public function myMark($control)
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('a')
            ->addSelect('b')
            ->from($this->_entityName, 'a')
            ->join('a.student', 'b')
            ->where('a.control = :control')
            ->setParameter('control', $control)
            ->andWhere('a.control.education.groupe = b.groupe');
        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    public function myfindAllMark($student, $groupe, $subject)
    {
        $query = $this->_em->createQuery('select m from TeckmebControlBundle:Control c, TeckmebCoreBundle:Education e, TeckmebCoreBundle:Promo p, TeckmebMarkBundle:Mark m, TeckmebCoreBundle:Groupe g where (c.education = e and e.groupe = :groupe and e.subject = :subject and m.control = c and m.student = :student) or (c.promo = p and p.semestre = g.semestre and p.subject = :subject and m.control = c and m.student = :student)');
        $query->setParameter('student', $student)
            ->setParameter('groupe', $groupe)
            ->setParameter('subject', $subject);
        return $query
            ->getResult();
    }

    public function myfindMarkByControl($control)
    {
        $query = $this->_em->createQuery('select m from TeckmebMarkBundle:Mark m where m.control = :control');
        $query->setParameter('control', $control);
        return $query
            ->getResult();
    }
}