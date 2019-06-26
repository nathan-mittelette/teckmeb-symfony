<?php

namespace Teckmeb\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RemoveBDController extends Controller
{
    public function removeBDAffichageAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $session = $request->getSession();
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Student');
        $listStudent = $repository->findAll();
        $tabStudent = array();
        $tabGroupeCount = array();
        $tabSemestreCount = array();
        $sessionStudent = array();
        $now = new \DateTime();
        foreach ($listStudent as $student) {
            if ($now->diff($this->getLastDate($student))->y >= 2) {
                $tabStudent[] = $student;
                $sessionStudent[] = $student->getId();
                foreach ($student->getGroupes() as $groupe) {
                    $tabGroupeCount[$groupe->getId()] = (isset($tabGroupeCount[$groupe->getId()])) ? ++$tabGroupeCount[$groupe->getId()] : 1;
                }
            }
        }
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Groupe');
        $listGroupe = $repository->findAll();
        $tabGroupe = array();
        $sessionGroupe = array();
        foreach ($listGroupe as $groupe) {
            if (count($groupe->getStudents()) == ((isset($tabGroupeCount[$groupe->getId()])) ? $tabGroupeCount[$groupe->getId()] : 0)) {
                $tabGroupe[] = $groupe;
                $sessionGroupe[] = $groupe->getId();
                $tabSemestreCount[$groupe->getSemestre()->getId()] = (isset($tabSemestreCount[$groupe->getSemestre()->getId()])) ? ++$tabSemestreCount[$groupe->getSemestre()->getId()] : 1;
            }
        }
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Semestre');
        $listSemestre = $repository->findAll();
        $tabSemestre = array();
        $sessionSemestre = array();
        foreach ($listSemestre as $semestre) {
            if (count($semestre->getGroupes()) == ((isset($tabSemestreCount[$semestre->getId()])) ? $tabSemestreCount[$semestre->getId()] : 0)) {
                $tabSemestre[] = $semestre;
                $sessionSemestre[] = $semestre->getId();
            }
        }
        $session->set("tabStudent", $sessionStudent);
        $session->set("tabGroupe", $sessionGroupe);
        $session->set("tabSemestre", $sessionSemestre);
        return $this->render('TeckmebAdministrationBundle::preRemove.html.twig', array(
            'listStudent' => $tabStudent,
            'listGroupe' => $tabGroupe,
            'listSemestre' => $tabSemestre
        ));
    }

    private function getLastDate($student)
    {
        $listGroupe = $student->getGroupes();
        foreach ($listGroupe as $grp) {
            $lastDate = (isset($lastDate)) ? ($lastDate->diff($grp->getSemestre()->getEndDate())->invert == 0) ? $grp->getSemestre()->getEndDate() : $lastDate : $grp->getSemestre()->getEndDate();
        }
        return $lastDate;
    }

    public function removeBDAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $session = $request->getSession();
        foreach ((($session->get("tabStudent") != null) ? $session->get("tabStudent") : array()) as $studentId) {
            $student = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Student")->find($studentId);
            $this->removeStudent($student);
        }
        foreach ((($session->get("tabGroupe") != null) ? $session->get("tabGroupe") : array()) as $groupeId) {
            $groupe = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Groupe")->find($groupeId);
            $this->removeGroupe($groupe);
        }
        foreach ((($session->get("tabSemestre") != null) ? $session->get("tabSemestre") : array()) as $semestreId) {
            $semestre = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Semestre")->find($semestreId);
            $this->removeSemestre($semestre);
        }
        $session->set("tabStudent", null);
        $session->set("tabGroupe", null);
        $session->set("tabSemestre", null);
        $session->getFlashBag()->add('info', 'La suppression des données à bien été effectué');
        return $this->redirectToRoute("teckmeb_administration_homepage");
    }

    private function removeSemestre($semestre)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Promo");
        $listPromo = $repository->findBySemestre($semestre);
        foreach ($listPromo as $promo) {
            $em->remove($promo);
        }
        $em->remove($semestre);
        $em->flush();
    }

    private function removeGroupe($groupe)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebControlBundle:Control");
        $listControl = $repository->myFindControlGroupeBis($groupe);
        foreach ($listControl as $control) {
            $em->remove($control);
        }
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Education");
        $listEducation = $repository->findByGroupe($groupe);
        foreach ($listEducation as $education) {
            $em->remove($education);
        }
        $em->remove($groupe);
        $em->flush();
    }

    private function removeStudent($student)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebTimeTableBundle:Timetable");
        $listTimetable = $repository->findByUser($student->getUser());
        foreach ($listTimetable as $timetable) {
            $em->remove($timetable);
        }
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebMarkBundle:Mark");
        $listMark = $repository->findByStudent($student);
        foreach ($listMark as $mark) {
            $em->remove($mark);
        }
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebAbsenceBundle:Absence");
        $listAbsence = $repository->findByStudent($student);
        foreach ($listAbsence as $absence) {
            $em->remove($absence);
        }
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebQuestionBundle:Question");
        $listQuestion = $repository->findByStudent($student);
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebQuestionBundle:Answer");
        foreach ($listQuestion as $question) {
            $listAnwser = $repository->findByQuestion($question);
            foreach ($listAnwser as $anwser) {
                $em->remove($anwser);
            }
            $em->remove($question);
        }
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebNotificationBundle:Notification");
        $listNotification = $repository->findByUser($student->getUser());
        foreach ($listNotification as $notification) {
            $em->remove($notification);
        }
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebPtutBundle:Ptut");
        $listPtut = $repository->myFindPtutByStudent($student);
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebPtutBundle:Appointment");
        foreach ($listPtut as $ptut) {
            $ptut->removeStudent($student);
            if (count($ptut->getStudents()) == 0) {
                $listAppointment = $repository->findbyPtut($ptut);
                foreach ($listAppointment as $appointment) {
                    $em->remove($appointment);
                }
                $em->remove($ptut);
            }
        }
        foreach ($student->getGroupes() as $groupe) {
            $groupe->removeStudent($student);
        }
        $em->remove($student);
        $em->remove($student->getUser());
        $em->flush();
    }
}