<?php

namespace Teckmeb\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Teckmeb\AdministrationBundle\Form\CourseType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourseController extends Controller
{
    public function modifyCourseAction($id, Request $request)
    {
        $session = $request->getSession();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebAdministrationBundle:Course');
        $course = $repository->findOneById($id);
        if (null === $course) {
            throw new NotFoundHttpException("Ce course d'id " . $id . " n'existe pas.");
        }
        $formModifyParcours = $this->createForm(CourseType::class, $course);
        if ($request->isMethod('POST') && $formModifyParcours->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($course);
            $em->flush();
            $session->getFlashBag()->add('info', 'Le parcours a bien été modifié');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        return $this->render('TeckmebAdministrationBundle::modifyCourse.html.twig', array(
            'formModifyParcours' => $formModifyParcours->createView(),
            'Administration' => true,
        ));
    }

    public function deleteCourseAction($id, Request $request)
    {
        $session = $request->getSession();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $em = $this->getDoctrine()->getManager();
        $repository = $em
            ->getRepository('TeckmebAdministrationBundle:Course');
        $course = $repository->findOneById($id);
        if (null === $course) {
            throw new NotFoundHttpException("Ce course d'id " . $id . " n'existe pas.");
        }
        $em->remove($course);
        $em->flush();
        $session->getFlashBag()->add('info', 'Le parcours a bien été supprimé');
        return $this->redirectToRoute('teckmeb_administration_homepage');
    }
}
