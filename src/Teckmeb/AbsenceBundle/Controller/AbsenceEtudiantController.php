<?php

namespace Teckmeb\AbsenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AbsenceEtudiantController extends Controller
{

    public function viewAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux élèves.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Student');
        $student = $repository->findOneByUser($this->getUser()->getId());
        $listGroupe = $student->getGroupes();
        $listAbsence = array();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebAbsenceBundle:Absence');
        foreach ($listGroupe as $groupe) {
            $listAbsence[$groupe->getSemestre()->getSemestreFullName()] = array('listAbsence2' => $repository->myFindAbsenceByGroupeStudent($groupe, $student), 'nameTabs' => $groupe->getSemestre()->getSchoolYear() . $groupe->getSemestre()->getCourse()->getCourseType()->getName());
        }
        return $this->render('TeckmebAbsenceBundle::view.html.twig', array(
            'listAbsence' => $listAbsence,
            'Absences' => true,
        ));
    }
}

