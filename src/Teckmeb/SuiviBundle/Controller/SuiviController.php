<?php

namespace Teckmeb\SuiviBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SuiviController extends Controller
{
    public function homeAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat et aux professeurs.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Student');
        $listStudent = $repository->findAll();
        return $this->render('TeckmebSuiviBundle::home.html.twig', array(
            'listStudent' => $listStudent,
            'Suivi' => true,
        ));
    }

    public function profileAction($numStudent)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat et aux professeurs.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Student');
        $student = $repository->findOneByNumStudent($numStudent);
        if (null === $student) {
            throw new NotFoundHttpException("Cet étudiant d'id " . $numStudent . " n'existe pas.");
        }
        $listGroupe = $student->getGroupes();
        $listOrderMark = array();
        foreach ($listGroupe as $groupe) {
            $SommeMoyenne = 0;
            $SommeDiviseur = 0;
            $listOrderMark[$groupe->getSemestre()->getSemestreFullName()] = array();
            $listTU = $groupe->getSemestre()->getCourse()->getTeachingUnits();
            foreach ($listTU as $TU) {
                $listOrderMark[$groupe->getSemestre()->getSemestreFullName()]['Notes']['TU'][$TU->getTeachingUnitFullName()] = $this->getAllContent($TU, $groupe, $student);
                $SommeMoyenne += ($listOrderMark[$groupe->getSemestre()->getSemestreFullName()]['Notes']['TU'][$TU->getTeachingUnitFullName()]['moyStudent'] != null) ? $listOrderMark[$groupe->getSemestre()->getSemestreFullName()]['Notes']['TU'][$TU->getTeachingUnitFullName()]['moyStudent'] : 0;
                $SommeDiviseur += ($listOrderMark[$groupe->getSemestre()->getSemestreFullName()]['Notes']['TU'][$TU->getTeachingUnitFullName()]['moyStudent'] != null) ? 20 : 0;
            }
            $listOrderMark[$groupe->getSemestre()->getSemestreFullName()]['Absences'] = $this->getAbsences($groupe, $student);
            $listOrderMark[$groupe->getSemestre()->getSemestreFullName()]['Notes']['Moyenne'] = ($SommeDiviseur != 0) ? ($SommeMoyenne / $SommeDiviseur) * 20 : 0;
        }
        return $this->render('TeckmebSuiviBundle::view.html.twig', array(
            'listOrderMark' => $listOrderMark,
            'Student' => $student,
            'Suivi' => true,
        ));
    }

    public function getAbsences($groupe, $student)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebAbsenceBundle:Absence');
        $listAbsence = $repository->myFindAbsenceByGroupeStudent($groupe, $student);
        $numJus = 0;
        $numNonJus = 0;
        foreach ($listAbsence as $abs) {
            if ($abs->getJustified()) {
                $numJus++;
            } else {
                $numNonJus++;
            }
        }
        return array('numJus' => $numJus, 'numNonJus' => $numNonJus);
    }

    public function getAllContent($TU, $groupe, $student)
    {
        $tabRetour = array();
        $listModule = $TU->getModules();
        $listSub = array();
        $listSubject = array();
        $moyStu = 0;
        $moyGroup = 0;
        $moyDiv = 0;
        foreach ($listModule as $module) {
            $listSub[] = $module->getSubjects();
        }
        foreach ($listSub as $list) {
            foreach ($list as $subject) {
                $listSubject[] = $subject;
            }
        }
        $tabSubject = array();
        foreach ($listSubject as $subject) {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebMarkBundle:Mark');
            $listControlMark = $repository->myFindAllMark($student, $groupe, $subject);
            $sommeStu = 0;
            $sommeDiv = 0;
            $sommeGroup = 0;
            $listMark = array();
            foreach ($listControlMark as $mark) {
                $listMark[] = $mark;
                $sommeStu += $mark->getValue();
                $sommeDiv += $mark->getControl()->getDivisor();
                $sommeGroup += $mark->getControl()->getMedian();
            }
            $moyStu += ($sommeDiv == 0) ? 0 : ($sommeStu / $sommeDiv) * 20;
            $moyGroup += ($sommeDiv == 0) ? 0 : ($sommeGroup / $sommeDiv) * 20;
            $moyDiv += ($sommeDiv == 0) ? 0 : 20;
            $tabSubject[] = array('moyStudent' => ($sommeDiv == 0) ? null : ($sommeStu / $sommeDiv) * 20, 'moyGroupe' => ($sommeDiv == 0) ? null : ($sommeGroup / $sommeDiv) * 20, 'subject' => $subject, 'listMark' => $listMark);
        }
        $tabRetour = array('teaching' => $TU, 'listSubject' => $tabSubject, 'moyStudent' => ($moyDiv == null) ? null : ($moyStu / $moyDiv) * 20, 'moyGroupe' => ($moyDiv == null) ? null : ($moyGroup / $moyDiv) * 20);
        return $tabRetour;
    }
}
