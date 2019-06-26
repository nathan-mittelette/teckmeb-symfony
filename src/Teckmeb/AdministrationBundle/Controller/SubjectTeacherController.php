<?php

namespace Teckmeb\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Teckmeb\CoreBundle\Entity\Education;
use Teckmeb\CoreBundle\Entity\Promo;
use Teckmeb\CoreBundle\Entity\Teacher;

class SubjectTeacherController extends Controller
{
    public function SubjectsAction($id, Request $request)
    {
        // Vérification que c'est bien le secrétériat qui accède à la page
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        // On récupère la session pour pouvoir retourner un message d'erreur si besoin
        $session = $request->getSession();
        // On récupère le groupe concerné
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Groupe');
        $groupe = $repository->find($id);
        // On vérifie qu'il existe
        if ($groupe == null) {
            $session->getFlashBag()->add('info', 'Ce groupe n\'existe pas');
            return $this->redirectToRoute('teckmeb_administration_homepage');
        }
        // Récupération de la ressource via la variable POST
        $ressource = $this->getRessource($_POST['ressource'], $session);
        // En cas d'erreur on redirige vers la page pour récupérer l'url
        if ($ressource == null) {
            return $this->redirectToRoute('teckmeb_administration_ressource', array('id' => $id));
        }
        // On récupère le contenu de l'emploi du temps
        $calendar = $this->getCalendar($ressource, $session);
        // En cas d'erreur on redirige vers la page d'ajout de l'url
        if ($calendar == null) {
            return $this->redirectToRoute('teckmeb_administration_ressource', array('id' => $id));
        }
        // On récupère les professeurs du fichier
        $tabResultat = $this->getTeachers($calendar, $session);
        // S'il n'y a pas de cours dans l'emploi du temps on redirige vers l'ajout de l'url
        if ($tabResultat == null) {
            return $this->redirectToRoute('teckmeb_administration_ressource', array('id' => $id));
        }
        // On recupère les résultats, soit les erreurs les choix à faire et les professeurs associés aux modules
        list($tabProfesseur, $tabErreur, $tabChoix) = $this->getResultat($tabResultat);
        // On enregistre le tableau dans la session pour une exploitation futur
        $session->set('tabGood', $tabProfesseur);
        $session->set('tabChoix', $tabChoix);
        return $this->render('TeckmebAdministrationBundle::subjectview.html.twig', array(
            'tabResultat' => $tabResultat,
            'tabGood' => $tabProfesseur,
            'tabBad' => $tabErreur,
            'tabChoix' => $tabChoix,
            'groupe' => $groupe,
        ));
    }

    private function getRessource($url, $session)
    {
        // On initialise le tableau qui va contenir les cours
        $data = array();
        // On récupère les attributs de l'url
        $arr = parse_url(htmlspecialchars($url));
        // On récupère les attributs GET de l'url
        $parameters = (isset($arr['query'])) ? $arr['query'] : null;
        // On vérifie qu'il y a bien des attributs GET dans la requête et principalement un attribut ressource
        if ($parameters == null) {
            $session->getFlashBag()->add('info', 'Erreur dans l\'url rentré');
            return null;
        }
        // On récupère chaque paramêtre de l'url dans un tableau
        parse_str($parameters, $data);
        if (!isset($data['resources'])) {
            $session->getFlashBag()->add('info', 'Erreur dans l\'url rentré');
            return null;
        }
        return $data['resources'];
    }

    private function getCalendar($ressource, $session)
    {
        $date = new \DateTime();
        $date1 = new \DateTime($date->format(\DateTimeInterface::ATOM) . " + 365 days");
        $date2 = new \DateTime($date->format(\DateTimeInterface::ATOM) . " - 365 days");
        // Création de l'url
        $url = "http://adelb.univ-lyon1.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources=" . $ressource . "&projectId=2&calType=ical&firstDate=" . $date2->format("Y-m-d") . "&lastDate=" . $date1->format("Y-m-d");
        // On récupère le contenu du fichier grâce à l'url
        $calendar = file_get_contents($url);
        // Vérification qu'il y a bien du contenu
        if (!$calendar) {
            $session->getFlashBag()->add('info', 'Erreur dans le numéro de ressource');
            return null;
        }
        return $calendar;
    }

    private function getTeachers($calendar, $session)
    {
        $tabResultat = array();
        $regExpCours = '/SUMMARY:(.*)/';
        $regExpDesc = '/DESCRIPTION:(.*)/';
        $coursTab = array();
        $descTab = array();
        $n = preg_match_all($regExpCours, $calendar, $coursTab, PREG_PATTERN_ORDER);
        preg_match_all($regExpDesc, $calendar, $descTab, PREG_PATTERN_ORDER);
        if ($n == 0) {
            $session->getFlashBag()->add('info', 'Erreur dans la valeur de la ressource');
            return null;
        }
        for ($j = 0; $j < $n; $j++) {
            $cours = substr($coursTab[0][$j], 8);
            $module = explode(' ', $cours)[0];
            if (preg_match('#^M[0-9]+#', $module) > 0) {
                $desc = substr($descTab[0][$j], 12);
                $desc = substr($desc, 0, mb_strripos($desc, '('));
                $desc = explode('\n', $desc);
                $tabProf = null;
                if (count($desc) > 2) {
                    for ($i = 2; preg_match('#^G[1-9]S[1-4]|S[1-4]$#', $desc[$i]) > 0; $i++) { }
                    $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('TeckmebCoreBundle:Subject');
                    $subject = $repository->findBySubjectCode($module);
                    $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('TeckmebUserBundle:User');
                    for (; $i < count($desc) - 1; $i++) {
                        if (count(explode(' ', $desc[$i])) > 1) {
                            $user = $repository->myfindUser(strtolower(explode(' ', $desc[$i])[1]), strtolower(explode(' ', $desc[$i])[0]));
                            $tabProf[] = array('nom' => explode(' ', $desc[$i])[0], 'prenom' => explode(' ', $desc[$i])[1], 'ModuleExiste' => ($subject != null), 'TeacherExiste' => ($user != null));
                        }
                    }
                    if ($tabProf != null) {
                        if (!isset($tabResultat[$module])) {
                            $tabResultat[$module][] = $tabProf;
                        } else if (!$this->compareTo($tabResultat[$module], $tabProf)) {
                            $tabResultat[$module][] = $tabProf;
                        }
                    }
                }
            }
        }
        return $tabResultat;
    }

    private function getResultat($tabResultat)
    {
        $tabChoix = array();
        $tabGood = array();
        $tabBad = array();
        foreach ($tabResultat as $module => $resultat) {
            if ($resultat[0][0]['ModuleExiste']) {
                $nb1 = 0;
                $indice1 = array();
                foreach ($resultat as $nb => $prof) {
                    if (count($prof) == 1) {
                        $indice1[] = $nb;
                        $nb1++;
                    }
                }
                if ($nb1 == 1) {
                    $tabGood[$module] = $resultat[$indice1[0]][0];
                } else {
                    $tabChoix[$module]['listProf'] = array();
                    foreach ($resultat as $prof) {
                        foreach ($prof as $ligne)
                            if (!$this->alreadyExistTeacher($tabChoix[$module]['listProf'], $ligne))
                                $tabChoix[$module]['listProf'][] = $ligne;
                    }
                }
            } else {
                $tabBad[$module]['erreur'] = "Le module n'existe pas en base de donnée";
                $tabBad[$module]['solution'] = 2;
                $tabBad[$module]['choix'] = array();
                foreach ($resultat as $prof) {
                    foreach ($prof as $ligne) {
                        if (!$this->alreadyExistTeacher($tabBad[$module]['choix'], $ligne))
                            $tabBad[$module]['choix'][] = $ligne;
                    }
                }
            }
        }
        return array($tabGood, $tabBad, $tabChoix);
    }

    private function alreadyExistTeacher($array, $professeur)
    {
        foreach ($array as $ligne) {
            if (strtolower($ligne['nom']) == strtolower($professeur['nom']) && strtolower($ligne['prenom']) == strtolower($professeur['prenom']))
                return true;
        }
        return false;
    }

    private function compareTo($tab1, $tab2)
    {
        $retourFct = false;
        foreach ($tab1 as $tabProf) {
            if (count($tabProf) == count($tab2)) {
                $retour = true;
                for ($i = 0; $i < count($tabProf); $i++) {
                    if ($tabProf[$i] != $tab2[$i]) {
                        $retour = false;
                    }
                }
            } else {
                $retour = false;
            }
            $retourFct = ($retourFct || $retour);
        }
        return $retourFct;
    }

    public function subjectValidateAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $session = $request->getSession();
        $tabGood = $session->get('tabGood');
        $tabChoix = $session->get('tabChoix');
        if ($tabGood === null) {
            $session->getFlashBag()->add('info', 'Erreur dans l\'ajout des professeurs');
            return $this->redirectToRoute('teckmeb_administration_ressource', array('id' => $id));
        }
        $em = $this->getDoctrine()->getManager();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Groupe');
        $groupe = $repository->find($id);
        $mailService = $this->get("teckmeb_core.mailService");
        foreach ($tabGood as $module => $ligne) {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Subject');
            $subject = $repository->findOneBySubjectCode($module);
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebUserBundle:User');
            $user = $repository->myFindUser(strtolower($ligne['prenom']), strtolower($ligne['nom']));
            $teacher = null;
            if ($user == null) {
                $user = $this->get('fos_user.user_manager')->createUser();
                $user->setEnabled(true);
                $user->setUsername(strtolower($ligne['prenom']) . '.' . strtolower($ligne['nom']));
                $user->setName($ligne['prenom']);
                $user->setSurname($ligne['nom']);
                $user->setPlainPassword("123");
                $email = htmlspecialchars($_POST[str_replace(".", "_", $module)]);
                $user->setEmail($email);
                $teacher = new Teacher();
                $teacher->setUser($user);
                $this->get('fos_user.user_manager')->updateUser($user);
                $mailService->addUserMail($user, true);
                $this->get('fos_user.user_manager')->updateUser($user);
            } else
                $user = $user[0];
            if ($teacher == null) {
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebCoreBundle:Teacher');
                $teacher = $repository->findByUser($user);
                if ($teacher == null) {
                    $teacher = new Teacher();
                    $teacher->setUser($user);
                    $em->persist($user);
                } else
                    $teacher = $teacher[0];
            }
            $teacher->addSubject($subject);
            $em->persist($teacher);
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Education');
            $education = $repository->myFindEducation($subject, $groupe);
            $education = ($education == null) ? new Education() : $education[0];
            $education->setGroupe($groupe);
            $education->setSubject($subject);
            $education->setTeacher($teacher);
            $em->persist($education);
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Promo');
            $promo = $repository->myFindPromo($subject, $groupe->getSemestre());
            if (count($promo) == 0) {
                $promo = new Promo();
                $promo->setSubject($subject);
                $promo->setSemestre($groupe->getSemestre());
                $em->persist($promo);
            }
            $em->flush();
        }
        foreach ($tabChoix as $module => $resultat) {
            $ligne = $resultat['listProf'][htmlspecialchars($_POST[$module . '-choix'])];
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Subject');
            $subject = $repository->findOneBySubjectCode($module);
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebUserBundle:User');
            $user = $repository->myFindUser(strtolower($ligne['prenom']), strtolower($ligne['nom']));
            $teacher = null;
            if ($user == null) {
                $user = $this->get('fos_user.user_manager')->createUser();
                $user->setEnabled(true);
                $user->setUsername(strtolower($ligne['prenom']) . '.' . strtolower($ligne['nom']));
                $user->setName($ligne['prenom']);
                $user->setSurname($ligne['nom']);
                $user->setPlainPassword("123");
                $email = htmlspecialchars($_POST[$module . '-email' . htmlspecialchars($_POST[$module . '-choix'])]);
                $user->setEmail($email);
                $teacher = new Teacher();
                $teacher->setUser($user);
                $this->get("fos_user.user_manager")->updateUser($user);
                $mailService->addUserMail($user, true);
                $this->get('fos_user.user_manager')->updateUser($user);
            } else
                $user = $user[0];
            if ($teacher == null) {
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebCoreBundle:Teacher');
                $teacher = $repository->findByUser($user);
                if ($teacher == null) {
                    $teacher = new Teacher();
                    $teacher->setUser($user);
                    $em->persist($user);
                } else
                    $teacher = $teacher[0];
            }
            $teacher->addSubject($subject);
            $em->persist($teacher);
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Education');
            $education = $repository->myFindEducation($subject, $groupe);
            $education = ($education == null) ? new Education() : $education[0];
            $education->setGroupe($groupe);
            $education->setSubject($subject);
            $education->setTeacher($teacher);
            $em->persist($education);
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Promo');
            $promo = $repository->myFindPromo($subject, $groupe->getSemestre());
            if (count($promo) == 0) {
                $promo = new Promo();
                $promo->setSubject($subject);
                $promo->setSemestre($groupe->getSemestre());
                $em->persist($promo);
            }
            $em->flush();
        }
        $session->getFlashBag()->add('info', 'Ajout des professeurs validé');
        return $this->redirectToRoute('teckmeb_administration_homepage');
    }

    public function ressourceAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Groupe');
        $groupe = $repository->find($id);
        if (null === $groupe) {
            throw new NotFoundHttpException("Ce groupe d'id " . $id . " n'existe pas.");
        }
        return $this->render('TeckmebAdministrationBundle::preSubject.html.twig', array(
            'groupe' => $groupe,
        ));
    }
}
