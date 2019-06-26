<?php

namespace Teckmeb\MarkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MarkController extends Controller
{
    public function verification($control)
    {
        if ($control->getEducation() != null) {
            return ($control->getEducation()->getTeacher()->getUser()->getId() == $this->getUser()->getId());
        } else {
            $teacher = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Teacher')->findOneByUser($this->getUser());
            $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Education');
            return (count($repository->myVerification($control, $teacher)) > 0);
        }
    }

    public function viewAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux étudiants.');
        }
        // On récupère les notes de l'utilisateur
        $user = $this->getUser();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Student');
        $student = $repository->findOneByUser($user);
        $listGroupe = $student->getGroupes();
        $listOrderMark = array();
        foreach ($listGroupe as $groupe) {
            $listModule = array();
            $listSubjectCollection = array();
            $listSubject = array();
            $SommeMoyenne = 0;
            $SommeDiviseur = 0;
            $listOrderMark[$groupe->getSemestre()->getSemestreFullName()] = array();
            $listTU = $groupe->getSemestre()->getCourse()->getTeachingUnits();
            foreach ($listTU as $TU) {
                $listModule[] = $TU->getModules();
            }
            foreach ($listModule as $module) {
                foreach ($module as $mod) {
                    $listSubjectCollection[] = $mod->getSubjects();
                }
            }
            foreach ($listSubjectCollection as $collection) {
                foreach ($collection as $subject) {
                    $listSubject[] = $subject;
                }
            }
            foreach ($listSubject as $subject) {
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebMarkBundle:Mark');
                $listControlMark = $repository->myFindAllMark($student, $groupe, $subject);
                if ($listControlMark != null) {
                    $sommeNote = 0;
                    $sommeDiviseur = 0;
                    foreach ($listControlMark as $mark) {
                        $sommeNote += $mark->getValue() * $mark->getControl()->getCoefficient();
                        $sommeDiviseur += $mark->getControl()->getDivisor() * $mark->getControl()->getCoefficient();
                    }
                    $moyenne = ($sommeNote / $sommeDiviseur) * 20;
                } else {
                    $moyenne = null;
                }
                $listOrderMark[$groupe->getSemestre()->getSemestreFullName()]['listSubject'][$subject->getSubjectFullName()] = array('listMark' => $listControlMark, 'Moyenne' => $moyenne, 'Coefficient' => $subject->getSubjectCoefficient(), 'subject' => $subject);
                $SommeMoyenne += ($moyenne != null) ? $moyenne * $subject->getSubjectCoefficient() : 0;
                $SommeDiviseur += ($moyenne != null) ? 20 * $subject->getSubjectCoefficient() : 0;
            }
            $listOrderMark[$groupe->getSemestre()->getSemestreFullName()]['Moyenne'] = ($SommeMoyenne != 0) ? ($SommeMoyenne / $SommeDiviseur) * 20 : null;
            $listOrderMark[$groupe->getSemestre()->getSemestreFullName()]['nameTabs'] = $groupe->getSemestre()->getSchoolYear() . $groupe->getSemestre()->getCourse()->getCourseType()->getName();
        }
        return $this->render('TeckmebMarkBundle::mark_view.html.twig', array(
            'listOrderMark' => $listOrderMark,
            'Mark' => true,
        ));
    }
}
