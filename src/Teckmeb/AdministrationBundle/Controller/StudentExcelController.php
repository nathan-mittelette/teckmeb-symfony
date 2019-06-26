<?php

namespace Teckmeb\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Teckmeb\CoreBundle\Entity\Student;
use Teckmeb\CoreBundle\Entity\Groupe;

class StudentExcelController extends Controller
{
    private function skip_accents($str, $charset = 'utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        $str = preg_replace('#&[^;]+;#', '', $str);
        return strtolower($str);
    }

    public function gestionAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $session = $request->getSession();
        $tab = array();
        $tabStudentError = array();
        $semestreCreate = false;
        if (isset($_FILES['excel']['tmp_name'])) {
            // Ouvrir un fichier Excel en lecture
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['excel']['tmp_name']);
            $courantcell = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, 1);
            for ($j = 2; $courantcell->getValue() != ""; $j++) {
                for ($i = 1; $i < 7; $i++) {
                    $courantcell = $spreadsheet->getActiveSheet()->getCellByColumnAndRow($i, $j);
                    $tab[$j][$i] = $courantcell->getValue();
                }
            }
            // Récupération des semestres
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Semestre');
            $tabSemestre = $repository->findAll();
            // Vérification des étudiants et des groupes
            $i = 1;
            foreach ($tab as $etudiant) {
                $error = null;
                if (!strlen($etudiant[1]) == 8) {
                    $error = "Le numéro étudiant est trop long";
                }
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebUserBundle:User');
                $student = null;
                $user = $repository->findOneByUsername('p' . substr($etudiant[1], -7));
                // On vérifie si l'utilisateur existe
                if ($user != null && $error == null) {
                    if ($user->getSurnameCanonical() == $this->skip_accents($etudiant[3]) && $user->getNameCanonical() == $this->skip_accents($etudiant[4])) {
                        $repository = $this
                            ->getDoctrine()
                            ->getManager()
                            ->getRepository('TeckmebCoreBundle:Student');
                        $student = $repository->findOneByUser($user);
                    } else {
                        $error = "Mauvais nom ou prénom pour cet utilisateur";
                    }
                }
                if ($error == null) {
                    // Si jamais il existe pas un etudiant avec cet user on le créer
                    if ($student == null) {
                        $user = $this->get('fos_user.user_manager')->createUser();
                        $user->setEnabled(true);
                        $user->setUsername('p' . substr($etudiant[1], -7));
                        $user->setName($etudiant[4]);
                        $user->setSurname($etudiant[3]);
                        $user->setPassword("123");
                        $user->setEmail($etudiant[4] . '.' . $etudiant[3] . '@etu.univ-lyon1.fr');
                        $student = new Student();
                        $student->setUser($user);
                    }
                    $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('TeckmebCoreBundle:ChoixGroupe');
                    $choixGroupe = ($etudiant[6] != null) ? $repository->find($etudiant[6]) : null;
                    if ($choixGroupe == null) {
                        $error = "Mauvais case pour groupe";
                        $tabStudentError[] = array('Nom' => $student->getUser()->getSurname(), 'Prenom' => $student->getUser()->getName(), 'Username' => $student->getUser()->getUsername(), 'Erreur' => $error, "Groupe" => $etudiant[6]);
                    } else {
                        $tabEtudiant[$etudiant[6]][] = array('Nom' => $student->getUser()->getSurname(), 'Prenom' => $student->getUser()->getName(), 'Username' => $student->getUser()->getUsername(), 'Groupe' => $etudiant[6], 'Student' => $student);
                    }
                } else {
                    $tabStudentError[] = array('Nom' => $etudiant[3], 'Prenom' => $etudiant[4], 'Username' => $etudiant[1], 'Erreur' => $error, "Groupe" => $etudiant[6]);
                }
            }
        } else {
            $session->getFlashBag()->add('info', 'Entrez un fichier');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        $session->set('tabEtudiant', $tabEtudiant);
        $session->set('tabStudentError', $tabStudentError);
        return $this->render('TeckmebAdministrationBundle::afficheExcel.html.twig', array(
            'Administration' => true,
            'tabSemestre' => $tabSemestre,
            'tabEtudiant' => $tabEtudiant,
            'tabStudentError' => $tabStudentError,
            'tab' => $tab,
        ));
    }

    public function traitementAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $tabStudentError = $session->get('tabStudentError');
        $mailService = $this->get("teckmeb_core.mailService");
        if ($tabStudentError != null) {
            if (count($tabStudentError) > 1) {
                $session->getFlashBag()->add('info', 'Il reste des erreurs dans le fichier excel');
                return $this->redirectToRoute('teckmeb_administration_homepage');
            } else {
                if (isset($_POST['selectSemestre'])) {
                    $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('TeckmebCoreBundle:Semestre');
                    $semestre = $repository->find((int)$_POST['selectSemestre']);
                    // Géré si semestre existe pas 
                } else {
                    $session->getFlashBag()->add('info', 'Il faut selectionner un semestre');
                    return $this->redirectToRoute('teckmeb_administration_homepage');
                }
                $tabEtudiant = $session->get('tabEtudiant');
                if ($tabEtudiant != null) {
                    foreach ($tabEtudiant as $key => $groupe) {
                        $repository = $this
                            ->getDoctrine()
                            ->getManager()
                            ->getRepository('TeckmebCoreBundle:ChoixGroupe');
                        $choixGroupe = $repository->find($key);
                        $repository = $this
                            ->getDoctrine()
                            ->getManager()
                            ->getRepository('TeckmebCoreBundle:Groupe');
                        $group = $repository->myfindGroupeBySemestre($semestre, $choixGroupe);
                        $group = (isset($group[0])) ? $group[0] : null;
                        if ($group == null) {
                            $group = new Groupe();
                            $group->setSemestre($semestre);
                            $group->setGroupName($choixGroupe);
                            $em->persist($group);
                        }
                        foreach ($groupe as $student) {
                            $repository = $this
                                ->getDoctrine()
                                ->getManager()
                                ->getRepository('TeckmebUserBundle:User');
                            $user = $repository->findOneByUsername($student['Username']);
                            if ($user == null) {
                                $user = $this->get('fos_user.user_manager')->createUser();
                                $user->setEnabled(true);
                                $user->setUsername($student['Username']);
                                $user->setName($student['Prenom']);
                                $user->setSurname($student['Nom']);
                                $user->setPlainPassword("123");
                                $user->setEmail($this->getMail($user));
                                $this->get('fos_user.user_manager')->updateUser($user);
                                $mailService->addUserMail($user, false);
                                $this->get('fos_user.user_manager')->updateUser($user);
                            }
                            $repository = $this
                                ->getDoctrine()
                                ->getManager()
                                ->getRepository('TeckmebCoreBundle:Student');
                            $student = $repository->findOneByUser($user);
                            if ($student == null) {
                                $student = new Student();
                                $student->setUser($user);
                                $student->setNumStudent($user->getUsername());
                            }
                            $group->addStudent($student);
                            $em->persist($student);
                        }
                    }
                    $em->flush();
                    $session->set('tabEtudiant', null);
                    $session->getFlashBag()->add('info', 'L\'ajout a bien été fait');
                    return $this->redirectToRoute('teckmeb_administration_homepage');
                } else {
                    $session->getFlashBag()->add('info', 'Erreur lors de l\'ajout des étudiants');
                    return $this->redirectToRoute('teckmeb_administration_homepage');
                }
            }
        }
        $session->getFlashBag()->add('info', 'Erreur lors l\'ajout des étudiants');
        return $this->redirectToRoute('teckmeb_administration_homepage');
    }

    function getMail($user)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebUserBundle:User');
        $nb = "";
        while($repository->findByEmail($user->getName() . '.' . $user->getSurname() . $nb . "@etu.univ-lyon1.fr") != null) {
            $nb = ($nb != "") ? $nb++ : 1;
        }
        return $user->getName() . '.' . $user->getSurname() . $nb . '@etu.univ-lyon1.fr';
    }
}
