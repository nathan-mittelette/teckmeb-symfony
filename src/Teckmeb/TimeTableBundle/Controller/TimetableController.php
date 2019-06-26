<?php

namespace Teckmeb\TimeTableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Teckmeb\TimeTableBundle\Form\TimetableType;
use Symfony\Component\HttpFoundation\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Exception;

class TimetableController extends Controller
{
    public function homeAction(Request $request)
    {
        $timetableService = $this->get("teckmeb_timetable.timetableService");
        $session = $request->getSession();
        $timetable = $timetableService->getTimetableFromUser($this->getUser());
        if ($timetable == null) {
            $timetable = $timetableService->initTimetable();

            $form = $this->get('form.factory')->create(TimetableType::class, $timetable);

            if ($request->isMethod('POST')) {
                // On récupère l'URL
                $form->handleRequest($request);
                try {
                    $timetable->setUser($this->getUser());
                    $timetableService->updateRessourceFromUrl($timetable);
                } catch (Exception $e) {
                    $session->getFlashBag()->add('info', $e->getMessage());
                    return $this->render('TeckmebTimeTableBundle::home.html.twig', array(
                        'form' => $form->createView(),
                        'Timetable' => true,
                    ));
                }
                $session->getFlashBag()->add('info', 'Emploi du temps a bien été ajouté');
                return $this->redirectToRoute('teckmeb_time_table_view');
            }
            return $this->render('TeckmebTimeTableBundle::home.html.twig', array(
                'form' => $form->createView(),
                'Timetable' => true,
            ));
        } else {
            return $this->redirectToRoute('teckmeb_time_table_view');
        }
    }

    public function modifyAction(Request $request)
    {
        $timetableService = $this->get("teckmeb_timetable.timetableService");
        $session = $request->getSession();
        $timetable = $timetableService->getTimetableFromUser($this->getUser());
        $timetable->setResource('');
        $form = $this->get('form.factory')->create(TimetableType::class, $timetable);
        if ($request->isMethod('POST')) {
            // On récupère l'URL
            $form->handleRequest($request);
            try {
                $timetable->setUser($this->getUser());
                $timetableService->updateRessourceFromUrl($timetable);
            } catch (Exception $e) {
                $session->getFlashBag()->add('info', $e->getMessage());
                return $this->render('TeckmebTimeTableBundle::home.html.twig', array(
                    'form' => $form->createView(),
                    'Timetable' => true,
                ));
            }
            $session->getFlashBag()->add('info', 'Emploi du temps a bien été modifié');
            return $this->redirectToRoute('teckmeb_time_table_view');
        }
        return $this->render('TeckmebTimeTableBundle::home.html.twig', array(
            'form' => $form->createView(),
            'Timetable' => true,
            'Retour' => true,
        ));
    }

    public function viewAction($date)
    {
        $timetableService = $this->get("teckmeb_timetable.timetableService");
        $timetable = $timetableService->getTimetableFromUser($this->getUser());
        if ($timetable == null) {
            return $this->redirectToRoute('teckmeb_time_table_homepage');
        }
        $periodeEDT = $this->get("teckmeb_timetable.periodeEDTService")->initPeriodeEDT($date);
        list($datePrec, $dateSuiv) = $timetableService->getOtherDate($periodeEDT->getDateDebut());
        list($tabDays, $tabHoraire, $tabDate, $tabDispo, $n) = $timetableService->getTimetableFromDate($timetable, $periodeEDT);
        return $this->render('TeckmebTimeTableBundle::timetable.html.twig', array(
            'tabDays' => $tabDays,
            'tabHoraire' => $tabHoraire,
            'tabDate' => $tabDate,
            'tabDispo' => $tabDispo,
            'datePrec' => $datePrec->format('Y-m-d'),
            'dateSuiv' => $dateSuiv->format('Y-m-d'),
            'Timetable' => true,
            'Vide' => ($n == 0) ? true : false,
        ));
    }
}
