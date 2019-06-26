<?php

namespace Teckmeb\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Teckmeb\AdministrationBundle\Form\TeachingUnitType;

class TUController extends Controller
{
    public function modifyTUAction($id, Request $request)
    {
        $session = $request->getSession();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebAdministrationBundle:TeachingUnit');
        $teachingUnit = $repository->findOneById($id);
        if (null === $teachingUnit) {
            throw new NotFoundHttpException("Ce teachingUnit d'id " . $id . " n'existe pas.");
        }
        $formModifyTU = $this->createForm(TeachingUnitType::class, $teachingUnit);
        if ($request->isMethod('POST') && $formModifyTU->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($teachingUnit);
            $em->flush();
            $session->getFlashBag()->add('info', 'L\'UE a bien été modifié');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        return $this->render('TeckmebAdministrationBundle::modifyTU.html.twig', array(
            'formModifyTU' => $formModifyTU->createView(),
            'Administration' => true,
        ));
    }
}
