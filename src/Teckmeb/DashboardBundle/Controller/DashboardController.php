<?php

namespace Teckmeb\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    public function dashboardAction(Request $request)
    {
        $checkService = $this->get('teckmeb_core.check.right');
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Student');
            $student = $repository->findOneByUser($this->getUser());
            if ($checkService->getValideForController('AbsenceEtudiant')) {
                list($just, $nonjust) = $this->getAbsences($student);
            }
            if ($checkService->getValideForController('Mark')) {
                $retourMark = $this->getMark($student);
            }
            if ($checkService->getValideForController('Ptut')) {
                $retourPtut = $this->getPtutStudent($student);
            }
            if ($checkService->getValideForController('Question')) {
                $question = $this->getQuestionStudent($student);
            }
            if ($checkService->getValideForController('Timetable')) {
                list($tabDays, $tabHoraire, $tabDate, $tabDispo) = $this->getEDT($request);
            }
        }
        else if ($this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Teacher');
            $teacher = $repository->findOneByUser($this->getUser());
            if ($checkService->getValideForController('Timetable')) {
                list($tabDays, $tabHoraire, $tabDate, $tabDispo) = $this->getEDT($request);
            }
            if ($checkService->getValideForController('Control')) {
                $listControl = $this->getControlForTeacher($teacher);
            }
            if ($checkService->getValideForController('Question')) {
                $question = $this->getQuestionForTeacher($teacher);
            }
            if ($checkService->getValideForController('Ptut')) {
                $listPtutNonValide = $this->getPtutForTeacher($teacher);
                $appointement = $this->getAppointmentForTeacher($teacher);
            }
        }
        else if ($this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            $listSemestre = $this->getSemestre();
            $listGroupe = $this->getGroupes();
            $listAbsence = $this->getLastAbsences();
        }

        return $this->render('TeckmebDashboardBundle:Dashboard:dashboard.html.twig', array(
            'tabDays' => (isset($tabDays)) ? $tabDays : null,
            'tabHoraire' => (isset($tabHoraire)) ? $tabHoraire : null,
            'tabDate' => (isset($tabDate)) ? $tabDate : null,
            'tabDispo' => (isset($tabDispo)) ? $tabDispo : null,
            'Justified' => (isset($just)) ? $just : null,
            'NonJustified' => (isset($nonjust)) ? $nonjust : null,
            'retourMark' => (isset($retourMark)) ? $retourMark : null,
            'retourPtut' => (isset($retourPtut)) ? $retourPtut : null,
            'question' => (isset($question)) ? $question : null,
            'listControl' => (isset($listControl)) ? $listControl : null,
            'listPtutNonValide' => (isset($listPtutNonValide)) ? $listPtutNonValide : null,
            'appointement' => (isset($appointement)) ? $appointement : null,
            'listSemestre' => (isset($listSemestre)) ? $listSemestre : null,
            'listGroupe' => (isset($listGroupe)) ? $listGroupe : null,
            'listAbsence' => (isset($listAbsence)) ? $listAbsence : null,
        ));
    }

    private function getSemestre() {
        return $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Semestre")->findActiveSemestre();
    }

    private function getGroupes() {
        return $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Groupe")->findActiveGroupes();
    }

    private function getLastAbsences() {
        $listAbsence = $this->getDoctrine()->getManager()->getRepository("TeckmebAbsenceBundle:Absence")->myFindLast();
        return (count($listAbsence) > 0) ? ((count($listAbsence) > 3) ? array_slice(array_reverse($listAbsence) , count($listAbsence) - 4 , 3) : $listAbsence) : null;
    }

    private function getAppointmentForTeacher($teacher)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebPtutBundle:Appointment');
        $listAppointment = $repository->myFindAppointment($teacher);
        return (count($listAppointment) > 0) ? ((count($listAppointment) > 4) ? array($listAppointment[count($listAppointment) - 1] , $listAppointment[count($listAppointment) - 2] , $listAppointment[count($listAppointment) - 3]) : $listAppointment) : null;
    }

    private function getPtutForTeacher($teacher)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebPtutBundle:Ptut');
        $listPtutNonValideTmp = $repository->findByTeacher($teacher);
        $listPtutNonValide = array();
        foreach ($listPtutNonValideTmp as $ptut) {
            if ($ptut->getValide() != true) {
                $listPtutNonValide[] = $ptut;
            }
        }
        return (count($listPtutNonValide) > 0) ? ((count($listPtutNonValide) > 4) ? array($listPtutNonValide[count($listPtutNonValide) - 1], $listPtutNonValide[count($listPtutNonValide) - 2], $listPtutNonValide[count($listPtutNonValide) - 3]) : $listPtutNonValide) : null;
    }

    private function getControlForTeacher($teacher)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebControlBundle:Control');
        $listControl = $repository->myFindAllControl($teacher);
        return (count($listControl) > 3) ? array($listControl[count($listControl) - 1], $listControl[count($listControl) - 2]) : $listControl;
    }

    private function getQuestionForTeacher($teacher)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebQuestionBundle:Question');
        return $question = $repository->findOneByTeacher($teacher);
    }

    private function getQuestionStudent($student)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebQuestionBundle:Question');
        $listQuestion = $repository->myFindQuestion($student);
        if (count($listQuestion) > 0) {
            $question = $listQuestion[count($listQuestion) - 1];
        }
        return (isset($question)) ? $question : null;
    }

    private function getPtutStudent($student)
    {
        $retourPtut = array();
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebPtutBundle:Ptut');
        $listPtutNonValide = $repository->myFindPtutValide($student);
        if (count($listPtutNonValide) >= 3) {
            for ($i = count($listPtutNonValide) - 1; $i >= 0 && $i > count($listPtutNonValide) - 3; $i--) {
                $retourPtut[] = $listPtutNonValide[$i];
            }
        } else {
            $retourPtut = $listPtutNonValide;
        }
        return $retourPtut;
    }

    private function getMark($student)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebMarkBundle:Mark');
        $listMark = $repository->findByStudent($student);
        $retourMark = array();
        for ($i = count($listMark) - 1; $i >= 0 && $i > count($listMark) - 3; $i--) {
            if ($listMark[$i]->getControl()->getPromo() != null) {
                if ($listMark[$i]->getControl()->getPromo()->getSemestre()->getId() == $student->getCurrentGroupe()->getSemestre()->getId()) {
                    $retourMark[] = $listMark[$i];
                }
            } else {
                if ($listMark[$i]->getControl()->getEducation()->getGroupe()->getId() == $student->getCurrentGroupe()->getId()) {
                    $retourMark[] = $listMark[$i];
                }
            }
        }
        return $retourMark;
    }

    private function getAbsences($student)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebAbsenceBundle:Absence');
        $listAbsence = $repository->findBy(array('groupe' => $student->getCurrentGroupe(), 'student' => $student));
        $just = 0;
        $nonjust = 0;
        foreach ($listAbsence as $absence) {
            if ($absence->getJustified()) {
                $just++;
            } else {
                $nonjust++;
            }
        }
        return array($just, $nonjust);
    }

    private function getEDT($request)
    {
        $timetableService = $this->get("teckmeb_timetable.timetableService");
        $timetable = $timetableService->getTimetableFromUser($this->getUser());
        if ($timetable != null) {
            $periodeEDT = $this->get("teckmeb_timetable.periodeEDTService")->initPeriodeEDT(new \DateTime(), true);
            list($tabDays, $tabHoraire, $tabDate, $tabDispo, $n) = $timetableService->getTimetableFromDate($timetable , $periodeEDT, true);
        }
        return array((isset($tabDays)) ? $tabDays : null, (isset($tabHoraire)) ? $tabHoraire : null, (isset($tabDate)) ? $tabDate : null, (isset($tabDispo)) ? $tabDispo : null, );
    }
}
