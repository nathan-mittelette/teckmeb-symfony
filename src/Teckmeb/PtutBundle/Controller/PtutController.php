<?php

namespace Teckmeb\PtutBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Teckmeb\PtutBundle\Entity\Ptut;
use Teckmeb\PtutBundle\Form\PtutType;
use Teckmeb\PtutBundle\Entity\Appointment;
use Teckmeb\NotificationBundle\Entity\Notification;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PtutController extends Controller
{
    public function homeAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            $user = $this->getUser();
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Student');
            $student = $repository->findOneByUser($user);
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebPtutBundle:Ptut');
            $listPtutNonValide = $repository->myFindPtut($student);
            $listPtut = $repository->myFindPtutValide($student);
        } else if ($this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            $user = $this->getUser();
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Teacher');
            $teacher = $repository->findOneByUser($user);
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebPtutBundle:Ptut');
            $listPtutTmp = $repository->findByTeacher($teacher);
            $listPtutNonValide = array();
            $listPtut = array();
            foreach ($listPtutTmp as $ptut) {
                if ($ptut->getValide() == true) {
                    $listPtut[] = $ptut;
                } else {
                    $listPtutNonValide[] = $ptut;
                }
            }
        }
        return $this->render('TeckmebPtutBundle::home.html.twig', array(
            'listPtutNonValide' => $listPtutNonValide,
            'listPtut' => $listPtut,
            'Ptut' => true
        ));
    }

    public function createAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            $user = $this->getUser();
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Student');
            $student = $repository->findOneByUser($user);
            $ptut = new Ptut();
            $ptut->addStudent($student);
            $form = $this->createForm(PtutType::class, $ptut);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $ptut->setValide(false);
                $em->persist($ptut);
                $notification = new Notification();
                $notification->setUser($ptut->getTeacher()->getUser());
                $notification->setDescription('Vous avez une nouvelle demande de Ptut');
                $notification->setHref($this->generateUrl('teckmeb_ptut_homepage'));
                $em->persist($notification);
                $em->flush();
                $request->getSession()->getFlashBag()->add('info', 'La demande a bien été envoyée');
                return $this->redirectToRoute('teckmeb_ptut_homepage');
            }
        } else {
            throw new AccessDeniedException('Accès limité aux étudiants.');
        }
        return $this->render('TeckmebPtutBundle::interactionPtut.html.twig', array(
            'form' => $form->createView(),
            'Ptut' => true,
            'Modifier' => false
        ));
    }

    public function modifyAction($id, Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebPtutBundle:Ptut");
            $ptut = $repository->find($id);
            if ($ptut->getTeacher()->getUser()->getId() != $this->getUser()->getId()) {
                throw new AccessDeniedException('Accès limité au professeur du ptut.');
            }
            $form = $this->createForm(PtutType::class, $ptut);
            $form->remove("teacher");
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($ptut);
                $em->flush();
                $request->getSession()->getFlashBag()->add('info', 'La modification a bien été effectuée');
                return $this->redirectToRoute('teckmeb_ptut_homepage');
            }
        } else {
            throw new AccessDeniedException('Accès limité au professeur du ptut.');
        }
        return $this->render('TeckmebPtutBundle::interactionPtut.html.twig', array(
            'form' => $form->createView(),
            'Ptut' => true,
            'Modifier' => true
        ));
    }

    public function deleteAction($id, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        $user = $this->getUser();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $teacher = $repository->findOneByUser($user);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebPtutBundle:Ptut');
        $ptut = $repository->find($id);
        if ($ptut === null) {
            throw new NotFoundHttpException("Ce ptut d'id " . $id . " n'existe pas.");
        }
        if ($ptut->getTeacher()->getUser()->getId() != $this->getUser()->getId()) {
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        if ($ptut->getTeacher()->getId() == $teacher->getId()) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository("TeckmebPtutBundle:Appointment");
            $listAppointement = $repository->findByPtut($ptut);
            foreach ($listAppointement as $app) {
                    $em->remove($app);
                }
            $em->remove($ptut);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'Le ptut a bien été supprimé');
        }
        return $this->redirectToRoute('teckmeb_ptut_homepage');
    }

    public function valideAction($id, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        $user = $this->getUser();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $teacher = $repository->findOneByUser($user);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebPtutBundle:Ptut');
        $ptut = $repository->find($id);
        if ($ptut === null) {
            throw new NotFoundHttpException("Ce ptut d'id " . $id . " n'existe pas.");
        }
        if ($ptut->getTeacher()->getUser()->getId() != $this->getUser()->getId()) {
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        if ($ptut->getTeacher()->getId() == $teacher->getId()) {
            $em = $this->getDoctrine()->getManager();
            $ptut->setValide(true);
            foreach ($ptut->getStudents() as $student) {
                $notification = new Notification();
                $notification->setUser($student->getUser());
                $notification->setDescription('Votre ptut a été validé');
                $notification->setHref($this->generateUrl('teckmeb_ptut_view', array('id' => $id)));
                $em->persist($notification);
            }
            $em->persist($ptut);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'La demande a bien été acceptée');
        }
        return $this->redirectToRoute('teckmeb_ptut_homepage');
    }

    public function viewAction($id, Request $request)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebPtutBundle:Ptut');
        $ptut = $repository->find($id);
        if ($ptut === null) {
            throw new NotFoundHttpException("Ce ptut d'id " . $id . " n'existe pas.");
        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            if ($ptut->getTeacher()->getUser()->getId() != $this->getUser()->getId()) {
                throw new AccessDeniedException('Accès limité aux professeurs.');
            }
        } else if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            $student = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Student')->findOneByUser($this->getUser());
            if (!$ptut->getStudents()->contains($student)) {
                throw new AccessDeniedException('Accès limité aux étudiants du ptut.');
            }
        } else {
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        if (isset($_POST['date']) && isset($_POST['time']) && $_POST['time'] != "" && $_POST['date'] != "") {
            $appointment = new Appointment();
            $appointment->setDate($this->dateToDateTime(htmlspecialchars($_POST['date']), htmlspecialchars($_POST['time'])));
            $appointment->setPtut($ptut);
            $appointment->setValide(false);
            $em = $this->getDoctrine()->getManager();
            $notificationService = $this->get("teckmeb_notification.notification");
            $notificationService->addNotification($ptut->getTeacher()->getUser(),'Vous avez une demande de rendez-vous',$this->generateUrl('teckmeb_ptut_view', array('id' => $id)));
            $em->persist($appointment);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'La demande de rendez-vous a bien été envoyée');
            return $this->redirectToRoute('teckmeb_ptut_view', array('id' => $id));
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebPtutBundle:Appointment');
        $listAppointement = $repository->findByPtut($ptut);
        $listValide = array();
        $listeNonValide = array();
        foreach ($listAppointement as $app) {
            if ($app->getValide()) {
                $listValide[] = $app;
            } else {
                if ($this->get('security.authorization_checker')->isGranted('ROLE_TEACHER'))
                    $listeNonValide[] = $app;
            }
        }
        return $this->render('TeckmebPtutBundle::view.html.twig', array(
            'ptut' => $ptut,
            'listValide' => $listValide,
            'listNonValide' => $listeNonValide,
            'Ptut' => true
        ));
    }
    function dateToDateTime($date, $time)
    {
        $tab = explode('/', $date);
        $dateR = new \DateTime($tab[2] . '-' . $tab[1] . '-' . $tab[0]);
        $tabTime = explode(':', $time);
        $dateR->setTime($tabTime[0], $tabTime[1]);
        return $dateR;
    }

    function deleteAppAction($id, Request $request)
    {
        $user = $this->getUser();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $teacher = $repository->findOneByUser($user);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebPtutBundle:Appointment');
        $app = $repository->find($id);
        if ($app === null) {
            throw new NotFoundHttpException("Ce rendez-vous d'id " . $id . " n'existe pas.");
        }
        $ptut = $app->getPtut();
        if ($ptut->getTeacher()->getUser()->getId() != $this->getUser()->getId()) {
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        if ($ptut->getTeacher()->getId() == $teacher->getId()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($app);
            $notificationService = $this->get("teckmeb_notification.notification");
            foreach ($ptut->getStudents() as $student) {
                $notificationService->addNotification($student->getUser(),'Le rendez n\'a pas été validé',$this->generateUrl('teckmeb_ptut_view', array('id' => $app->getPtut()->getId())));
            }
            $request->getSession()->getFlashBag()->add('info', 'La demande de rendez-vous a bien été refusée');
            $em->flush();
        }
        return $this->redirectToRoute('teckmeb_ptut_view', array('id' => $ptut->getId()));
    }

    function valideAppAction($id, Request $request)
    {
        $user = $this->getUser();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $teacher = $repository->findOneByUser($user);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebPtutBundle:Appointment');
        $app = $repository->find($id);
        if ($app === null) {
            throw new NotFoundHttpException("Ce rendez-vous d'id " . $id . " n'existe pas.");
        }
        $ptut = $app->getPtut();
        if ($ptut->getTeacher()->getUser()->getId() != $this->getUser()->getId()) {
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        if ($ptut->getTeacher()->getUser()->getId() != $this->getUser()->getId()) {
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        if ($ptut->getTeacher()->getId() == $teacher->getId()) {
            $em = $this->getDoctrine()->getManager();
            $app->setValide(true);
            $notificationService = $this->get("teckmeb_notification.notification");
            foreach ($ptut->getStudents() as $student) {
                $notificationService->addNotification($student->getUser(),'Votre rendez-vous a été validé',$this->generateUrl('teckmeb_ptut_view', array('id' => $ptut->getId())));
            }
            $em->persist($app);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'La demande de rendez-vous a bien été validée');
        }
        return $this->redirectToRoute('teckmeb_ptut_view', array('id' => $ptut->getId()));
    }

    function addCommentAction($id, Request $request)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebPtutBundle:Appointment');
        $app = $repository->find($id);
        if ($app === null) {
            throw new NotFoundHttpException("Ce rendez-vous d'id " . $id . " n'existe pas.");
        }
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT') && $app->getPtut()->getTeacher()->getUser()->getId() != $this->getUser()->getId()) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            $student = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Student')->findOneByUser($this->getUser());
            if (!$app->getPtut()->getStudents->contains($student)) {
                throw new AccessDeniedException('Accès limité aux étudiants du ptut.');
            }
        }
        $ptut = $app->getPtut();
        $em = $this->getDoctrine()->getManager();
        $app->setComment(htmlspecialchars($_POST['comment']));
        $em->persist($app);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', 'Votre commentaire a bien été ajouté');
        return $this->redirectToRoute('teckmeb_ptut_view', array('id' => $ptut->getId()));
    }
}
