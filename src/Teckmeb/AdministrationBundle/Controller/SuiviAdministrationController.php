<?php

namespace Teckmeb\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Teckmeb\UserBundle\Form\UserEditType;
use Teckmeb\CoreBundle\Form\TeacherType;

class SuiviAdministrationController extends Controller
{
    public function suiviTeacherAction($id, Request $request)
    {
        $session = $request->getSession();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $teacher = $repository->find($id);
        if (null === $teacher) {
            throw new NotFoundHttpException("Ce professeur d'id " . $id . " n'existe pas.");
        }
        $formAddSubject = $this->createForm(TeacherType::class, $teacher);
        if ($request->isMethod('POST') && $formAddSubject->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teacher);
            $em->flush();
            $session->getFlashBag()->add('info', 'Les ajouts de sujet au professeur ont bien été pris en compte');
            return $this->redirectToRoute('teckmeb_administration_suivi_teacher' , array("id" => $id));
        }
        return $this->render('TeckmebAdministrationBundle::suiviTeacher.html.twig', array(
            'formAddSubject' => $formAddSubject->createView(),
            'Administration' => true,
            'Teacher' => $teacher,
        ));
    }

    public function modifyTeacherAction($id, Request $request) {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $teacher = $repository->find($id);
        if (null === $teacher) {
            throw new NotFoundHttpException("Cet étudiant d'id " . $id . " n'existe pas.");
        }
        $formDefineUser = $this->createForm(UserEditType::class, $teacher->getUser());
        if ($request->isMethod('POST') && $formDefineUser->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teacher->getUser());
            $em->flush();
            $session->getFlashBag()->add('info', 'Les modifications du professeur ' . $teacher->getUser()->getSurname() . " " . $teacher->getUser()->getName() . ' ont bien été prises en compte');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        return $this->render('TeckmebAdministrationBundle::updateTeacher.html.twig', array(
            'Administration' => true,
            'formDefineUser' => $formDefineUser->createView(),
            'teacher' => $teacher,
        ));
    }

    public function suiviStudentAction($id, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Student');
        $student = $repository->find($id);
        if (null === $student) {
            throw new NotFoundHttpException("Cet étudiant d'id " . $id . " n'existe pas.");
        }
        $formDefineUser = $this->createForm(UserEditType::class, $student->getUser());
        if ($request->isMethod('POST') && $formDefineUser->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student->getUser());
            $em->flush();
            $session->getFlashBag()->add('info', 'Les modifications de l\'étudiant ' . $student->getUser()->getSurname() . " " . $student->getUser()->getName() . ' ont bien été prises en compte');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        return $this->render('TeckmebAdministrationBundle::suiviStudent.html.twig', array(
            'Administration' => true,
            'formDefineUser' => $formDefineUser->createView(),
            'student' => $student,
        ));
    }

    public function passwordChangeAction($id, Request $request)
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
        $student = $repository->find($id);
        if (null === $student) {
            throw new NotFoundHttpException("Cet étudiant d'id " . $id . " n'existe pas.");
        }
        $password = $this->generatePassword();
        $user = $student->getUser();
        $user->setPlainPassword($password);
        $em->persist($user);
        $em->flush();

        //return new Response("Utilisateur : " . $student->getNumStudent() . "<br/>Le nouveau password est : " . $password);
        $request->getSession()->getFlashBag()->add('info', "Le mot de passe à bien été réinitialisé");
        return $this->redirectToRoute("teckmeb_administration_suivi_student", array("id" => $student->getId()));
    }

    public function generatePassword()
    {
        $tabCaract = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ*/-_1234567890";
        $retour = "";
        for ($i = 0; $i < 10; $i++) {
            $retour = $retour . substr($tabCaract, rand(0, strlen($tabCaract)), 1);
        }
        return $retour;
    }
}
