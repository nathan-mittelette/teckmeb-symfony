<?php

namespace Teckmeb\ProcessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Teckmeb\CoreBundle\Entity\Education;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Teckmeb\CoreBundle\Entity\Promo;
use Teckmeb\AbsenceBundle\Entity\Absence;
use Symfony\Component\HttpFoundation\Request;
use Teckmeb\NotificationBundle\Entity\Notification;

class ProcessController extends Controller
{
    public function allStudentAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Student');
        $listStudent = $repository->findAll();
        $tabStudent = array();
        foreach ($listStudent as $student) {
                $tabStudent[] = array('username' => $student->getUser()->getUsername(), 'id' => $student->getId());
            }
        $response = new Response(json_encode(array('listStudent' => $tabStudent)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function allTeacherAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $listTeacher = $repository->findAll();
        $tabTeacher = array();
        foreach ($listTeacher as $teacher) {
                $tabTeacher[] = array('username' => $teacher->getUser()->getUsername(), 'id' => $teacher->getId());
            }
        $response = new Response(json_encode(array('listTeacher' => $tabTeacher)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function allSubjectAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Groupe');
        $groupe = $repository->find($id);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $listSubject = array();
        $listEducation = array();
        $listForm = array();
        if ($groupe->getSemestre() != null) {
                $listTU = $groupe->getSemestre()->getCourse()->getTeachingUnits();
                foreach ($listTU as $tu) {
                        $listModule = $tu->getModules();
                        foreach ($listModule as $module) {
                                $listSubjectCollection[] = $module->getSubjects();
                            }
                    }
                foreach ($listSubjectCollection as $collection) {
                        foreach ($collection as $subject) {
                                $listTeacher = array();
                                $listTeacherReturn = $repository->myFindTeacherBySubject($subject);
                                foreach ($listTeacherReturn as $teacher) {
                                        $listTeacher[] = array('username' => $teacher->getUser()->getUsername(), 'id' => $teacher->getId());
                                    }
                                $listSubject[] = array('subjectName' => $subject->getSubjectFullName(), 'subjectId' => $subject->getId(), 'listTeacher' => $listTeacher);
                            }
                    }
            }
        $response = new Response(json_encode(array('listSubject' => $listSubject, 'groupeId' => $groupe->getId())));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function valideEduAction($idGroupe, $idTeacher, $idSubject)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Subject');
        $subject = $repository->find($idSubject);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Groupe');
        $groupe = $repository->find($idGroupe);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $teacher = $repository->find($idTeacher);
        if ($teacher != null && $groupe != null && $subject != null) {
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebCoreBundle:Education');
                $edu = $repository->myFindEducation($subject, $groupe);
                if ($edu != null) {
                        $tmp = null;
                        foreach ($edu as $ed) {
                                $ed->setTeacher($teacher);
                                $tmp = $ed;
                            }
                        $edu = $tmp;
                    } else {
                        $edu = new Education();
                        $edu->setSubject($subject);
                        $edu->setGroupe($groupe);
                        $edu->setTeacher($teacher);
                    }
                $em = $this->getDoctrine()->getManager();
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebCoreBundle:Promo');
                $promo = $repository->myFindPromo($subject, $groupe->getSemestre());
                if ($promo == null) {
                        $promo = new Promo();
                        $promo->setSubject($subject);
                        $promo->setSemestre($groupe->getSemestre());
                        $em->persist($promo);
                    }
                $em->persist($edu);
                $em->flush();
            } else {
                throw new NotFoundHttpException("Erreur dans le choix des composants de l'éducation");
            }
        return new Response();
    }

    public function getAllStudentGroupeAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $em = $this->getDoctrine()->getManager();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Student');
        $listStudent = $repository->findAll();
        $listStudentRetour = array();
        foreach ($listStudent as $student) {
                $groupe = null;
                $listGroupe = $student->getGroupes();
                foreach ($listGroupe as $groupeL) {
                        if ($groupeL->getSemestre() != null) {
                                $groupe = ($groupeL->getSemestre()->getActive()) ? $groupeL : null;
                            }
                    }
                if ($groupe != null) {
                        $listStudentRetour[] = array('StudentId' => $student->getId(), 'StudentUsername' => $student->getUser()->getUsername(), 'groupe' => $groupe->getGroupFullName());
                    }
            }
        $response = new Response(json_encode(array('listStudent' => $listStudentRetour)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function ajoutAbsenceAction($justified, $date, $absenceId, $studentId, $buttonMatin, $buttonApres, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $messageRetour = "";
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Student');
        $student = $repository->find($studentId);
        $groupe = $student->getCurrentGroupe();

        if ($buttonMatin > 0 && $groupe != null) {
                $absence = new Absence();
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebCoreBundle:Student');
                $absence->setStudent($student);
                $absence->setGroupe($groupe);
                $absence->setJustified(($justified == "true") ? true : false);
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebAbsenceBundle:AbsenceType');
                $absence->setAbsenceType($repository->find($absenceId));
                $dateBisFin = new \DateTime($date);
                $dateBisDebut = new \DateTime($date);
                switch ($buttonMatin) {
                    case 1:
                        $dateBisDebut = $dateBisDebut->setTime(8, 0);
                        $dateDebut = $dateBisDebut;
                        $dateBisFin = $dateBisFin->setTime(10, 0);
                        $dateFin = $dateBisFin;
                        break;
                    case 2:
                        $dateBisDebut = $dateBisDebut->setTime(10, 0);
                        $dateDebut = $dateBisDebut;
                        $dateBisFin = $dateBisFin->setTime(12, 0);
                        $dateFin = $dateBisFin;
                        break;
                    case 3:
                        $dateBisDebut = $dateBisDebut->setTime(8, 0);
                        $dateDebut = $dateBisDebut;
                        $dateBisFin = $dateBisFin->setTime(12, 0);
                        $dateFin = $dateBisFin;
                        break;
                }
                $absence->setBeginDate($dateDebut);
                $absence->setEndDate($dateFin);
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebAbsenceBundle:Absence');
                $retourAbsence = $repository->myFindAbsence($absence->getStudent(), $absence->getBeginDate(), $absence->getEndDate());
                if ($retourAbsence == null) {
                        $em->persist($absence);
                        $messageRetour = "Absence bien ajouté";
                        $notification = new Notification();
                        $notification->setUser($student->getUser());
                        $notification->setNotsee(true);
                        $notification->setDate(new \DateTime());
                        $notification->setDescription('Ajout d\'une absence');
                        $notification->setHref($this->generateUrl('teckmeb_absence_view'));
                        $em->persist($notification);
                    } else {
                        $messageRetour = "Absence déjà existante";
                    }
            }
        if ($buttonApres > 0  && $groupe != null) {
                $absence = new Absence();
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebCoreBundle:Student');
                $absence->setStudent($student);
                $absence->setGroupe($groupe);
                $absence->setJustified(($justified == "true") ? true : false);
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebAbsenceBundle:AbsenceType');
                $absence->setAbsenceType($repository->find($absenceId));
                $dateBisFin = new \DateTime($date);
                $dateBisDebut = new \DateTime($date);
                switch ($buttonApres) {
                    case 1:
                        if ($dateBisDebut->format('w') == 5) {
                                $dateBisDebut = $dateBisDebut->setTime(13, 30);
                                $dateBisFin = $dateBisFin->setTime(15, 30);
                            } else {
                                $dateBisDebut = $dateBisDebut->setTime(14, 0);
                                $dateBisFin = $dateBisFin->setTime(16, 0);
                            }
                        $dateFin = $dateBisFin;
                        $dateDebut = $dateBisDebut;
                        break;
                    case 2:
                        if ($dateBisDebut->format('w') == 5) {
                                $dateBisDebut = $dateBisDebut->setTime(15, 30);
                                $dateBisFin = $dateBisFin->setTime(17, 30);
                            } else {
                                $dateBisDebut = $dateBisDebut->setTime(16, 0);
                                $dateBisFin = $dateBisFin->setTime(18, 0);
                            }
                        $dateFin = $dateBisFin;
                        $dateDebut = $dateBisDebut;
                        break;
                    case 3:
                        if ($dateBisDebut->format('w') == 5) {
                                $dateBisDebut = $dateBisDebut->setTime(13, 30);
                                $dateBisFin = $dateBisFin->setTime(17, 30);
                            } else {
                                $dateBisDebut = $dateBisDebut->setTime(14, 0);
                                $dateBisFin = $dateBisFin->setTime(18, 0);
                            }
                        $dateFin = $dateBisFin;
                        $dateDebut = $dateBisDebut;
                        break;
                }
                $absence->setBeginDate($dateDebut);
                $absence->setEndDate($dateFin);
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebAbsenceBundle:Absence');
                $retourAbsence = $repository->myFindAbsence($absence->getStudent(), $absence->getBeginDate(), $absence->getEndDate());
                if ($retourAbsence == null) {
                        $em->persist($absence);
                        $messageRetour = "Absence bien ajouté";
                        $notification = new Notification();
                        $notification->setUser($student->getUser());
                        $notification->setNotsee(true);
                        $notification->setDate(new \DateTime());
                        $notification->setDescription('Ajout d\'une absence');
                        $notification->setHref($this->generateUrl('teckmeb_absence_view'));
                        $em->persist($notification);
                    } else {
                        $messageRetour = "Absence déjà existante";
                    }
            }
        $em->flush();
        $response = new Response(json_encode(array('messageRetour' => $messageRetour)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getFlashAction(Request $request)
    {
        $session = $request->getSession();
        $listFlash = [];
        foreach ($session->getFlashBag()->get('info', array()) as $message) {
                $listFlash[] = $message;
            }
        $response = new Response(json_encode(array('listFlash' => $listFlash)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
