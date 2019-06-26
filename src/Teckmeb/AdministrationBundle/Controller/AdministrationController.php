<?php

namespace Teckmeb\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Teckmeb\AdministrationBundle\Entity\Course;
use Teckmeb\AdministrationBundle\Entity\TeachingUnit;
use Teckmeb\AdministrationBundle\Form\CourseType;
use Teckmeb\AdministrationBundle\Form\TeachingUnitType;
use Teckmeb\AdministrationBundle\Entity\Module;
use Teckmeb\AdministrationBundle\Form\ModuleType;
use Teckmeb\CoreBundle\Entity\Semestre;
use Teckmeb\CoreBundle\Form\SemestreType;
use Teckmeb\CoreBundle\Entity\Subject;
use Teckmeb\CoreBundle\Form\SubjectType;
use Teckmeb\CoreBundle\Entity\Groupe;
use Teckmeb\CoreBundle\Form\GroupeType;
use Teckmeb\UserBundle\Form\UserType;
use Teckmeb\CoreBundle\Entity\Student;
use Teckmeb\CoreBundle\Entity\Teacher;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdministrationController extends Controller
{
    public function homeAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $course = new Course();
        $formAjoutParcours = $this->get('form.factory')->create(CourseType::class, $course);
        if ($request->isMethod('POST') && $formAjoutParcours->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($course);
            $request->getSession()->getFlashBag()->add('info', 'Parcours bien ajouté');
            $em->flush();
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebAdministrationBundle:Course');
        $listCourse = $repository->findAll();
        $teachingUnit = new TeachingUnit();
        $formAjoutTU = $this->get('form.factory')->create(TeachingUnitType::class, $teachingUnit);
        if ($request->isMethod('POST') && $formAjoutTU->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teachingUnit);
            $request->getSession()->getFlashBag()->add('info', 'UE bien ajouté');
            $em->flush();
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebAdministrationBundle:TeachingUnit');
        $listTeachingUnit = $repository->findAll();
        $module = new Module();
        $formAjoutModule = $this->get('form.factory')->create(ModuleType::class, $module);
        if ($request->isMethod('POST') && $formAjoutModule->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'Module bien ajouté');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebAdministrationBundle:Module');
        $listModule = $repository->findAll();
        $subject = new Subject();
        $formAjoutSubject = $this->get('form.factory')->create(SubjectType::class, $subject);
        if ($request->isMethod('POST') && $formAjoutSubject->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'Sujet bien ajouté');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Subject');
        $listSubject = $repository->findAll();
        $semestre = new Semestre();
        $formAjoutSemestre = $this->get('form.factory')->create(SemestreType::class, $semestre);
        if ($request->isMethod('POST') && $formAjoutSemestre->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($semestre);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'Semestre bien ajouté');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Semestre');
        $listSemestre = $repository->findAll();
        $groupe = new Groupe();
        $formAjoutGroupe = $this->get('form.factory')->create(GroupeType::class, $groupe);
        if ($request->isMethod('POST') && $formAjoutGroupe->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($groupe);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'Groupe bien ajouté');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Groupe');
        $listGroupe = $repository->findAll();
        $user = $this->get('fos_user.user_manager')->createUser();
        $user->setEnabled(true);
        $mailService = $this->get("teckmeb_core.mailService");
        $formCreateUser = $this->get('form.factory')->create(UserType::class, $user);
        if ($request->isMethod('POST') && $formCreateUser->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $student = new Student();
            $student->setUser($user);
            $this->get('fos_user.user_manager')->updateUser($user);
            $mailService->addUserMail($user, false);
            $em->persist($user);
            $em->persist($student);
            $this->get('fos_user.user_manager')->updateUser($user, true);
            $request->getSession()->getFlashBag()->add('info', 'Etudiant bien ajouté');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        $user2 = $this->get('fos_user.user_manager')->createUser();
        $user2->setEnabled(true);
        $formCreateTeacher = $this->get('form.factory')->create(UserType::class, $user2);
        if ($request->isMethod('POST') && $formCreateTeacher->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $teacher = new Teacher();
            $teacher->setUser($user2);
            $this->get('fos_user.user_manager')->updateUser($user2);
            $mailService->addUserMail($user2, true);
            $em->persist($teacher);
            $this->get('fos_user.user_manager')->updateUser($user2, true);
            $request->getSession()->getFlashBag()->add('info', 'Professeur bien ajouté');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Student');
        $listStudent = $repository->findAll();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $listTeacher = $repository->findAll();
        return $this->render('TeckmebAdministrationBundle::administration.html.twig', array(
            'formAjoutParcours' => $formAjoutParcours->createView(),
            'Administration' => true,
            'listCourse' => $listCourse,
            'listTeachingUnit' => $listTeachingUnit,
            'formAjoutTU' => $formAjoutTU->createView(),
            'formAjoutModule' => $formAjoutModule->createView(),
            'listModule' => $listModule,
            'formAjoutSubject' => $formAjoutSubject->createView(),
            'listSubject' => $listSubject,
            'formAjoutSemestre' => $formAjoutSemestre->createView(),
            'listSemestre' => $listSemestre,
            'formAjoutGroupe' => $formAjoutGroupe->createView(),
            'listGroupe' => $listGroupe,
            'formCreateUser' => $formCreateUser->createView(),
            'formCreateTeacher' => $formCreateTeacher->createView(),
            'listStudent' => $listStudent,
            'listTeacher' => $listTeacher,
        ));
    }
}
