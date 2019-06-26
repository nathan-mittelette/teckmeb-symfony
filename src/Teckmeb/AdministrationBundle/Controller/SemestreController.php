<?php

namespace Teckmeb\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Teckmeb\CoreBundle\Form\GroupeForSemestreType;
use Teckmeb\CoreBundle\Form\SemestreType;
use Teckmeb\CoreBundle\Entity\Groupe;

class SemestreController extends Controller
{
    public function deleteGroupeFromSemestreAction($idGroupe, $idSemestre, Request $request)
    {
        $session = $request->getSession();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Semestre');
        $semestre = $repository->find($idSemestre);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Groupe');
        $groupe = $repository->find($idGroupe);
        if (null === $groupe) {
            throw new NotFoundHttpException("Ce groupe d'id " . $idGroupe . " n'existe pas.");
        }
        if (null === $semestre) {
            throw new NotFoundHttpException("Ce semestre d'id " . $idSemestre . " n'existe pas.");
        }
        $semestre->removeGroupe($groupe);
        $em = $this->getDoctrine()->getManager();
        $em->persist($semestre);
        $em->flush();
        $session->getFlashBag()->add('info', 'Le groupe a bien été supprimé du semestre');
        return $this->redirectToRoute('teckmeb_administration_modify_semestre', array('id' => $idSemestre));
    }

    public function modifySemestreAction($id, Request $request)
    {
        $session = $request->getSession();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Semestre');
        $semestre = $repository->find($id);
        if (null === $semestre) {
            throw new NotFoundHttpException("Ce semester d'id " . $id . " n'existe pas.");
        }
        $formModifySemestre = $this->createForm(SemestreType::class, $semestre);
        $groupe = new Groupe();
        $formAjoutGroupe = $this->createForm(GroupeForSemestreType::class, $groupe);
        if ($request->isMethod('POST') && $formModifySemestre->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($semestre);
            $em->flush();
            $session->getFlashBag()->add('info', 'Le semestre a bien été modifié');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        if ($request->isMethod('POST') && $formAjoutGroupe->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $groupe->setSemestre($semestre);
            $em->persist($groupe);
            $em->flush();
            $session->getFlashBag()->add('info', 'Le groupe a bien été ajouté au semestre');
            return $this->redirectToRoute('teckmeb_administration_modify_semestre', array('id' => $id));
        }
        return $this->render('TeckmebAdministrationBundle::modifySemestre.html.twig', array(
            'formModifySemestre' => $formModifySemestre->createView(),
            'Administration' => true,
            'semestre' => $semestre,
            'formAjoutGroupe' => $formAjoutGroupe->createView(),
        ));
    }
}
