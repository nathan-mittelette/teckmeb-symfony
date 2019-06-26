<?php

namespace Teckmeb\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Teckmeb\AdministrationBundle\Form\ModuleType;

class ModuleAdministrationController extends Controller
{
    public function deleteModuleAction($id, Request $request)
    {
        $session = $request->getSession();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $em = $this->getDoctrine()->getManager();
        $repository = $em
            ->getRepository('TeckmebAdministrationBundle:Module');
        $module = $repository->findOneById($id);
        if (null === $module) {
            throw new NotFoundHttpException("Ce module d'id " . $id . " n'existe pas.");
        }
        $em->remove($module);
        $em->flush();
        $session->getFlashBag()->add('info', 'Le module a bien été supprimé');
        return $this->redirectToRoute('teckmeb_administration_homepage');
    }

    public function modifyModuleAction($id, Request $request)
    {
        $session = $request->getSession();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebAdministrationBundle:Module');
        $module = $repository->findOneById($id);
        if (null === $module) {
            throw new NotFoundHttpException("Ce module d'id " . $id . " n'existe pas.");
        }
        $formModifyModule = $this->createForm(ModuleType::class, $module);
        if ($request->isMethod('POST') && $formModifyModule->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();
            $session->getFlashBag()->add('info', 'Le module a bien été modifié');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        return $this->render('TeckmebAdministrationBundle::modifyModule.html.twig', array(
            'formModifyModule' => $formModifyModule->createView(),
            'Administration' => true,
        ));
    }
}
