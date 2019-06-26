<?php

namespace Teckmeb\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Teckmeb\CoreBundle\Form\SubjectType;

class SubjectController extends Controller
{
    public function modifySubjectAction($id, Request $request)
    {
        $session = $request->getSession();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Subject');
        $subject = $repository->find($id);
        if (null === $subject) {
            throw new NotFoundHttpException("Ce sujet d'id " . $id . " n'existe pas.");
        }
        $form = $this->createForm(SubjectType::class, $subject);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();
            $session->getFlashBag()->add('info', 'Le sujet a bien été modifié');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        return $this->render('TeckmebAdministrationBundle::modifySubject.html.twig', array(
            'form' => $form->createView(),
            'Administration' => true,
        ));
    }
}
