<?php

namespace Teckmeb\PtutBundle\Repository;

/**
 * PtutRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PtutRepository extends \Doctrine\ORM\EntityRepository
{
    public function myFindPtut($student)
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('p')
            ->from('TeckmebPtutBundle:Ptut', 'p')
            ->where(':student MEMBER OF p.students')
            ->AndWhere('p.valide = 0')
            ->setParameter('student', $student);
        return $queryBuilder->getQuery()->getResult();
    }

    public function myFindPtutValide($student)
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('p')
            ->from('TeckmebPtutBundle:Ptut', 'p')
            ->where(':student MEMBER OF p.students')
            ->AndWhere('p.valide = 1')
            ->setParameter('student', $student);
        return $queryBuilder->getQuery()->getResult();
    }

    public function myFindPtutByStudent($student)
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('p')
            ->from('TeckmebPtutBundle:Ptut', 'p')
            ->where(':student MEMBER OF p.students')
            ->setParameter('student', $student);
        return $queryBuilder->getQuery()->getResult();
    }
}
