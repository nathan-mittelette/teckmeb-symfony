<?php

namespace Teckmeb\ControlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Teckmeb\MarkBundle\Entity\Mark;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MarkExcelController extends Controller
{
    private function verification($control)
    {
        if ($control->getEducation() != null) {
            return ($control->getEducation()->getTeacher()->getUser()->getId() == $this->getUser()->getId());
        } else {
            $teacher = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Teacher')->findOneByUser($this->getUser());
            $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Education');
            return (count($repository->myVerification($control, $teacher)) > 0);
        }
    }

    public function addExcelAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebControlBundle:Control');
        $control = $repository->find($id);
        if ($control === null) {
            throw new NotFoundHttpException("Ce control d'id " . $id . " n'existe pas.");
        }
        if (!$this->verification($control)) {
            throw new AccessDeniedException('Accès limité aux professuers.');
        }
        return $this->render('TeckmebMarkBundle::add.html.twig', array(
            'control' => $control,
        ));
    }

    private function getParametreForView()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Controller");
        $controller = $repository->findOneByNomController("MarkExcel");
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:OptionController");
        $listOption = $repository->findByController($controller);
        foreach ($listOption as $opt) {
                switch ($opt->getNomOption()) {
                    case "Position du numero étudiant":
                        $posIdStudent = $this->getExcelCoord($opt->getValue());
                        break;
                    case "Position de la note":
                        $posNote = $this->getExcelCoord($opt->getValue());
                        break;
                }
            }
        $start = max((isset($posIdStudent['ligne'])) ? $posIdStudent['ligne'] : 0, (isset($posNote['ligne'])) ? $posNote['ligne'] : 0) + 1;
        return array($start, $posIdStudent, $posNote);
    }

    private function getExcelForGet()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Controller");
        $controller = $repository->findOneByNomController("MarkExcel");
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:OptionController");
        $listOption = $repository->findByController($controller);
        foreach ($listOption as $opt) {
                switch ($opt->getNomOption()) {
                    case "Position du numero étudiant":
                        $posIdStudent = $this->getExcelCoord($opt->getValue());
                        break;
                    case "Position de la note":
                        $posNote = $this->getExcelCoord($opt->getValue());
                        break;
                    case "Position du nom du DS":
                        $posDs = $this->getExcelCoord($opt->getValue());
                        break;
                    case "Position du nom du groupe":
                        $posGroupe = $this->getExcelCoord($opt->getValue());
                        break;
                    case "Position du nom de l'étudiant":
                        $posNom = $this->getExcelCoord($opt->getValue());
                        break;
                    case "Position du prénom de l'étudiant":
                        $posPrenom = $this->getExcelCoord($opt->getValue());
                        break;
                }
            }
        return array($posGroupe, $posIdStudent, $posNom, $posPrenom, $posNote, $posDs);
    }

    private function getExcelCoord($value)
    {
        preg_match("#^[A-Z]*#", $value, $resultat);
        return array("colonne" => ord($resultat[0]) - 64, "ligne" => str_replace($resultat[0], "", $value));
    }

    public function viewExcelAction($id, Request $request)
    {
        $session = $request->getSession();
        $session->set('tabRetour', null);
        $session->set('tabError', null);
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebControlBundle:Control');
        $control = $repository->find($id);
        if ($control === null) {
            throw new NotFoundHttpException("Ce control d'id " . $id . " n'existe pas.");
        }
        if (!$this->verification($control)) {
            throw new AccessDeniedException('Accès limité aux professuers.');
        }
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Teacher');
        $teacher = $repository->findOneByUser($this->getUser());
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Groupe');
        $listGroup = ($control->getPromo() == null) ? array($control->getEducation()->getGroupe()) : $repository->findMyGroupes($teacher, $control->getPromo()->getSubject());
        if (isset($_FILES['excel']['tmp_name'])) {
            // Ouvrir un fichier Excel en lecture
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['excel']['tmp_name']);
            list($start, $posIdStudent, $posNote) = $this->getParametreForView();
            $i = $start;
            $j = 1;
            $tab = array();
            $courantcell = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($j, $i);
            while ($courantcell->getValue() != "") {
                for (; $courantcell->getValue() != ""; $i++) {
                    $tab[] = array(1 => $spreadsheet->getActiveSheet()->getCellByColumnAndRow($posIdStudent['colonne'], $i)->getValue(), 2 => $spreadsheet->getActiveSheet()->getCellByColumnAndRow($posNote['colonne'], $i)->getValue());
                    $courantcell = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($j, $i + 1);
                }
                $i = 4;
                $posIdStudent['colonne'] += 5;
                $posNote['colonne'] += 5;
                $j += 5;
                $courantcell = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($j, $i + 1);
            }
            $tabRetour = array();
            $tabErreur = array();
            foreach ($tab as $student) {
                $stud = $this->verificationStudent($student[1], $listGroup);
                if ($stud) {
                    if ($student[2] < 0 || $student[2] > $control->getDivisor()) {
                        $tabErreur[] = array('Id' => $student[1], 'Note' => $student[2], 'Message' => 'La note ne correspond pas : ' . $control->getDivisor());
                    } else {
                        $tabRetour[] = array('Student' => $stud, 'Note' => $student[2]);
                    }
                } else {
                    $tabErreur[] = array('Id' => $student[1], 'Note' => $student[2], 'Message' => 'Cet etudiant n\'existe pas en base');
                }
            }
        } else {
            $session->getFlashBag()->add('info', 'Entrez un fichier');
            return $this->redirectToRoute('teckmeb_mark_add', array('id' => $control->getId()));
        }
        foreach ($listGroup as $grp) {
            foreach ($grp->getStudents() as $std) {
                $ajout = true;
                foreach ($tabRetour as $student) {
                    if ($std->getId() == $student['Student']->getId()) {
                        $ajout = false;
                        break;
                    }
                }
                if ($ajout) {
                    $tabErreur[] = array('Id' => $std, 'Note' => 'Pas de note', "Message" => "Cet étudiant n'a pas de note");
                }
            }
        }
        $session->set('tabRetour', $tabRetour);
        $session->set('tabError', $tabErreur);
        return $this->render('TeckmebMarkBundle::addExcel.html.twig', array(
            'tabErreur' => $tabErreur,
            'tabRetour' => $tabRetour,
            'control' => $control,
            'Control' => true,
        ));
    }

    public function ajoutMarkAction($id, Request $request)
    {
        $session = $request->getSession();
        $tabRetour = $session->get('tabRetour');
        $tabErreur = $session->get('tabError');
        if (count($tabErreur) > 0) {
            foreach ($tabErreur as $err) {
                if ($err['Message'] != "Cet étudiant n'a pas de note") {
                    $session->getFlashBag()->add('info', 'Il reste des erreurs dans le fichier excel');
                    return $this->redirectToRoute('teckmeb_mark_add', array('id' => $id));
                }
            }
        }
        if ($tabRetour == null) {
            $session->getFlashBag()->add('info', 'Il y a eu une erreur dans l\'ajout des notes');
            return $this->redirectToRoute('teckmeb_mark_add', array('id' => $id));
        }
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebControlBundle:Control');
        $control = $repository->find($id);
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebMarkBundle:Mark');
        $listMark = $repository->findByControl($control);
        $em = $this->getDoctrine()->getManager();
        $notificationService = $this->get('teckmeb_notification.notification');
        foreach ($tabRetour as $student) {
            $mark = $this->ajoutMark($student, $listMark, $control, $notificationService);
            $em->persist($mark);
            $em->persist($mark->getStudent());
        }
        $em->flush();
        $this->get('teckmeb_control.control.check')->updateControlAverages($control, true);
        $session->set('tabError', null);
        $session->set('tabRetour', null);
        $session->getFlashBag()->add('info', 'L\'ajout des notes a été fait');
        return $this->redirectToRoute('teckmeb_control_homepage');
    }

    private function ajoutMark($student, $listMark, $control, $notificationService)
    {
        foreach ($listMark as $mark) {
            if ($student['Student']->getId() == $mark->getStudent()->getId()) {
                $mark->setValue($student['Note']);
                $notificationService->addNotification($this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Student')->find($student['Student']->getId())->getUser(), 'Ajout d\'une note', $this->generateUrl('teckmeb_mark_view'));
                return $mark;
            }
        }
        $mark = new Mark();
        $mark->setControl($control);
        $mark->setStudent($this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Student')->find($student['Student']->getId()));
        $mark->setValue($student['Note']);
        $notificationService->addNotification($this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Student')->find($student['Student']->getId())->getUser(), 'Ajout d\'une note', $this->generateUrl('teckmeb_mark_view'));
        return $mark;
    }

    private function verificationStudent($studentId, $listGroup)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Student');
        $student = $repository->findOneByNumStudent('p' . substr($studentId, -7));
        if ($student == null) {
            return false;
        }
        foreach ($listGroup as $group) {
            if ($group->getStudents()->contains($student)) {
                return $student;
            }
        }
        return false;
    }

    public function getExcelAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebControlBundle:Control');
        $control = $repository->find($id);
        if ($control === null) {
            throw new NotFoundHttpException("Ce control d'id " . $id . " n'existe pas.");
        }
        if (!$this->verification($control)) {
            throw new AccessDeniedException('Accès limité aux professuers.');
        }
        $url = "assets/excel/";
        // Ouvrir un fichier Excel en lecture
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($url . 'ModeleNotes.xlsx');
        list($posGroupe, $posIdStudent, $posNom, $posPrenom, $posNote, $posDs) = $this->getExcelForGet();
        $courantcell = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($posDs['colonne'], $posDs['ligne']);
        $courantcell->setValue($control->getControlName());
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $teacher = $repository->findByUser($this->getUser());
        // Si c'est un ds de promo alors .. 
        if ($control->getEducation() == null) {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Groupe');
            // On récupère les groupes concerné par le ds de promo
            $listGroup = $repository->findMyGroupes($teacher, $control->getPromo()->getSubject());
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Student');
            // Pour tout les groupes on récupère les élèves appartenant a ce groupe
            foreach ($listGroup as $group) {
                $listGroupe[] = array('listStudent' => $repository->myFindStudentByGroupe($group), 'groupe' => $group);
            }
        } else {
            // Si c'est pas un ds de promo on récupère les élèves appartenant au groupe concerné par le ds
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Student');
            $listStudent = $repository->myFindStudentByGroupe($control->getEducation()->getGroupe());
            $listGroupe[] = array('listStudent' => $listStudent, 'groupe' => $control->getEducation()->getGroupe());
        }
        $offset = max($posDs['ligne'], $posGroupe['ligne'], $posIdStudent['ligne'], $posNom['ligne'], $posPrenom['ligne'], $posNote['ligne']) + 1;
        $i = max($posDs['ligne'], $posGroupe['ligne'], $posIdStudent['ligne'], $posNom['ligne'], $posPrenom['ligne'], $posNote['ligne']) + 1;
        $j = 1;
        foreach ($listGroupe as $group) {
            $spreadsheet->getActiveSheet()->getCellByColumnAndRow($posGroupe['colonne'], $posGroupe['ligne'])->setValue($group['groupe']);
            $spreadsheet->getActiveSheet()->getCellByColumnAndRow($posIdStudent['colonne'], $posIdStudent['ligne'])->setValue("Id Etudiant");
            $spreadsheet->getActiveSheet()->getCellByColumnAndRow($posNom['colonne'], $posNom['ligne'])->setValue("Nom");
            $spreadsheet->getActiveSheet()->getCellByColumnAndRow($posPrenom['colonne'], $posPrenom['ligne'])->setValue("Prénom");
            $spreadsheet->getActiveSheet()->getCellByColumnAndRow($posNote['colonne'], $posNote['ligne'])->setValue("Note");
            for (; $i < count($group['listStudent']) + $offset; $i++) {
                $spreadsheet->getActiveSheet()->getCellByColumnAndRow($posIdStudent['colonne'], $i)->setValue($group['listStudent'][$i - $offset]->getNumStudent());
                $spreadsheet->getActiveSheet()->getCellByColumnAndRow($posNom['colonne'], $i)->setValue($group['listStudent'][$i - $offset]->getUser()->getSurname());
                $spreadsheet->getActiveSheet()->getCellByColumnAndRow($posPrenom['colonne'], $i)->setValue($group['listStudent'][$i - $offset]->getUser()->getName());
            }
            $posIdStudent['colonne'] += 5;
            $posNom['colonne'] += 5;
            $posPrenom['colonne'] += 5;
            $posGroupe['colonne'] += 5;
            $posNote['colonne'] += 5;
            $i = 4;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save($url . 'Notes.xlsx');
        $response = new Response();
        $response->setContent(file_get_contents($url . 'Notes.xlsx'));
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-disposition', 'filename=Notes.xlsx');
        return $response;
    }
}
