<?php

namespace Teckmeb\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Teckmeb\CoreBundle\Form\GroupeEditType;

class GroupeController extends Controller
{
    public function modifyGroupeAction($id, Request $request)
    {
        $session = $request->getSession();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Groupe');
        $groupe = $repository->find($id);
        if (null === $groupe) {
            throw new NotFoundHttpException("Ce groupe d'id " . $id . " n'existe pas.");
        }
        $formModifyGroupe = $this->createForm(GroupeEditType::class, $groupe);
        if ($request->isMethod('POST') && $formModifyGroupe->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($groupe);
            $em->flush();
            $session->getFlashBag()->add('info', 'Le groupe a bien été modifié');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        $listSubject = array();
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
                    $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('TeckmebCoreBundle:Teacher');
                    $listTeacher = $repository->myFindTeacherBySubject($subject);
                    $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('TeckmebCoreBundle:Education');
                    $education = $repository->myFindEducation($subject, $groupe);
                    $teacher = ($education != null) ? $education[0]->getTeacher() : null;
                    $listSubject[] = array('Subject' => $subject, 'Teachers' => $listTeacher, 'check' => ($education != null), 'Teacher' => $teacher);
                }
            }
        }
        return $this->render('TeckmebAdministrationBundle::modifyGroupe.html.twig', array(
            'formModifyGroupe' => $formModifyGroupe->createView(),
            'Administration' => true,
            'listSubject' => $listSubject,
            'groupe' => $groupe,
        ));
    }

    public function deleteGroupeAction($id, Request $request)
    {
        $session = $request->getSession();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Groupe');
        $groupe = $repository->find($id);
        if ($groupe != null) {
            $groupe = $repository->find($id);
            $listStudent = $groupe->getStudents();
            foreach ($listStudent as $student) {
                $groupe->removeStudent($student);
            }
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Education');
            $listEdu = $repository->findByGroupe($groupe);
            $em = $this->getDoctrine()->getManager();
            foreach ($listEdu as $edu) {
                $em->remove($edu);
            }
            $em->remove($groupe);
            $em->flush();
        } else {
            throw new NotFoundHttpException("Ce groupe d'id " . $id . " n'existe pas.");
        }
        $session->getFlashBag()->add('info', 'Le groupe a bien été supprimé');
        return $this->redirectToRoute('teckmeb_administration_homepage');
    }
}
