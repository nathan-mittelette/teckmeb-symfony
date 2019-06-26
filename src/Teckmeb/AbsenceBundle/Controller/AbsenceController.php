<?php

namespace Teckmeb\AbsenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Teckmeb\AbsenceBundle\Form\AbsenceType;
use Teckmeb\AbsenceBundle\Entity\Absence;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AbsenceController extends Controller
{
    public function homeAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $absence = new Absence();
        $formAbsence = $this->get('form.factory')->create(AbsenceType::class, $absence);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Student');
        $listStudent = $repository->findAll();
        return $this->render('TeckmebAbsenceBundle::home.html.twig', array(
            'formAbsence' => $formAbsence->createView(),
            'listStudent' => $listStudent,
            'Absences' => true,
        ));
    }

    private function verificationDate($date)
    {
        if ($date == null) {
            return null;
        }
        try {
            new \DateTime(htmlspecialchars($date));
            return $date;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function viewAllAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $dateDebut = $this->verificationDate((isset($_POST['dateDebut'])) ? htmlspecialchars($_POST['dateDebut']) : null);
        $dateFin = $this->verificationDate((isset($_POST['dateFin'])) ? htmlspecialchars($_POST['dateFin']) : null);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebAbsenceBundle:Absence');
        $listAbsence = $repository->myFindAll($dateDebut, $dateFin);
        return $this->render('TeckmebAbsenceBundle::viewAll.html.twig', array(
            'listAbsence' => $listAbsence,
            'Absences' => true,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin
        ));
    }

    public function deleteAction($id, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebAbsenceBundle:Absence');
        $absence = $repository->find($id);
        if (null === $absence) {
            throw new NotFoundHttpException("Cette absence d'id " . $id . " n'existe pas.");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($absence);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', 'Absence bien supprimée');
        return $this->redirectToRoute('teckmeb_absence_viewAll');
    }

    public function modifyAction($id, Request $request)
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
            ->getRepository('TeckmebAbsenceBundle:Absence');
        $absence = $repository->find($id);
        if (null === $absence) {
            throw new NotFoundHttpException("Cette absence d'id " . $id . " n'existe pas.");
        }
        $formAbsence = $this->get('form.factory')->create(AbsenceType::class, $absence);
        if ($request->isMethod('POST') && $formAbsence->handleRequest($request)->isValid() && isset($_POST['heureDebut']) && isset($_POST['heureFin'])) {
            $date = new \DateTime($absence->getBeginDate()->format('Y/m/d'));
            $dateFin = $date;
            $dateDebut = $absence->getBeginDate()->setTime(0, 0);
            $hDebut = htmlspecialchars($_POST['heureDebut']);
            $hFin = htmlspecialchars($_POST['heureFin']);
            $dateFin->setTime(substr($hFin, 0, 2), substr($hFin, -2), 0);
            $dateDebut->setTime(substr($hDebut, 0, 2), substr($hDebut, -2), 0);
            $retourAbsence = $repository->myFindAbsenceBis($absence->getStudent(), $dateDebut, $dateFin, $absence->getId());
            if ($retourAbsence == null) {
                $em->persist($absence);
            } else {
                $messageRetour = "Absence déjà existante";
                return $this->render('TeckmebAbsenceBundle::modify.html.twig', array(
                    'formAbsence' => $formAbsence->createView(),
                    'absence' => $absence,
                    'Absences' => true,
                    'MessageRetour' => $messageRetour
                ));
            }
            $absence->setBeginDate($dateDebut);
            $absence->setEndDate($dateFin);
            $em->persist($absence);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'Absence bien modifiée');
            return $this->redirectToRoute('teckmeb_absence_viewAll');
        }
        return $this->render('TeckmebAbsenceBundle::modify.html.twig', array(
            'formAbsence' => $formAbsence->createView(),
            'absence' => $absence,
            'Absences' => true,
        ));
    }

    public function modifyJustificationAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $em = $this->getDoctrine()->getManager();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebAbsenceBundle:Absence');
        $absence = $repository->find($id);
        if (null === $absence) {
            throw new NotFoundHttpException("Cette absence d'id " . $id . " n'existe pas.");
        }
        $absence->setJustified(!$absence->getJustified());
        $em->persist($absence);
        $em->flush();
        return $this->redirectToRoute('teckmeb_absence_viewAll');
    }
}
