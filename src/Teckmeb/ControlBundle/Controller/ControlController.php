<?php

namespace Teckmeb\ControlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Teckmeb\ControlBundle\Entity\Control;
use Teckmeb\ControlBundle\Form\ControlType;
use Teckmeb\ControlBundle\Form\ControlEditType;
use Teckmeb\ControlBundle\Form\ControlAddPromoType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Teckmeb\ControlBundle\Model\FiltreControl;
use Teckmeb\ControlBundle\Form\FiltreControlType;

class ControlController extends Controller
{
    public function indexAction(Request $request)
    {
        // On vérifie que l'utilisateur dispose bien du rôle ROLE_TEACHER
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux professuers.');
        }

        // Création du formulaire de filtre
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $teacher = $repository->findByUser($this->getUser());

        $filter = new FiltreControl();
        $formFiltre = $this->createForm(FiltreControlType::class, $filter, array('teacher' => $teacher));
        //Si le formulaire a été validé on persist les données
        if ($request->isMethod('POST') && $formFiltre->handleRequest($request)->isValid());
        // On les récupère
        list($subject, $groupe, $controlType) = $filter->getAll();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebControlBundle:Control');
        $listControl = $repository->myFindAllControl($teacher, $subject, $groupe, $controlType);
        return $this->render(
            'TeckmebControlBundle::control.html.twig',
            array(
                'listControl' => $listControl,
                'formFiltre' => $formFiltre->createView(),
            )
        );
    }

    public function addAction(Request $request)
    {
        // On récupère la classe control et on appelle le formulaire
        // Si on est en POST alors on valide les données et on redirige vers l'accueil du bundle
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux professuers.');
        }
        $control = new Control();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $teacher = $repository->findByUser($this->getUser());
        $form = $this->createForm(ControlType::class, $control, array('teacher' => $teacher));
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebControlBundle:ControlType');
            $controlType = $repository->findOneByControlTypeName('Groupe');
            $control->setControlType($controlType);
            $em->persist($control);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'DS bien ajouté');
            return $this->redirectToRoute('teckmeb_control_homepage');
        }
        return $this->render('TeckmebControlBundle::add.html.twig', array(
            'form' => $form->createView(),
            'Control' => true,
        ));
    }

    public function addPromoAction(Request $request)
    {
        // Même principe juste le formulaire est different
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux professuers.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebCoreBundle:Teacher');
        $teacher = $repository->findByUser($this->getUser());
        $control = new Control();
        $form = $this->createForm(ControlAddPromoType::class, $control, array('teacher' => $teacher));
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebControlBundle:ControlType');
            $controlType = $repository->findOneByControlTypeName('Promo');
            $control->setControlType($controlType);
            $em->persist($control);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'DS bien ajouté');
            return $this->redirectToRoute('teckmeb_control_homepage');
        }
        return $this->render('TeckmebControlBundle::add.html.twig', array(
            'form' => $form->createView(),
            'Control' => true,
        ));
    }

    public function editMarkAction($id, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux professuers.');
        }
        // Récupère le controle devant être édité
        $em = $this->getDoctrine()->getManager();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebControlBundle:Control');
        $control = $repository->find($id);
        if (null === $control) {
            throw new NotFoundHttpException("Ce control d'id " . $id . " n'existe pas.");
        }
        if (!$this->verificationMark($control)) {
            throw new AccessDeniedException('Accès limité aux professuers.');
        }
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
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebMarkBundle:Mark');
        // On récupère les differentes notes du controle
        $listMark = $repository->findByControl($control);
        foreach ($listGroupe as $groupe) {
            foreach ($groupe['listStudent'] as $student) {
                // On parcours tout les étudiants et si jamais les notes on été renvoyé on rentre dans la boucle
                if (isset($_POST[$student->getId()])) {
                    $form = true;
                    // On vérifie que la note est positive et inférieur au diviseur
                    if ($_POST[$student->getId()] >= 0 && $_POST[$student->getId()] <= $control->getDivisor() && $_POST[$student->getId()] != "") {
                        $complete = false;
                        foreach ($listMark as $mark) {
                            if ($mark->getStudent() == $student) {
                                $mark->setValue($_POST[$student->getId()]);
                                $em->persist($mark);
                                $complete = true;
                            }
                        }
                        if (!$complete) {
                            $mark = new Mark();
                            $mark->setStudent($student);
                            $mark->setControl($control);
                            $mark->setValue($_POST[$student->getId()]);
                            $em->persist($mark);
                        }
                        $this->get('teckmeb_notification.notification')->addNotification($student->getUser(), 'Ajout d\'une note', $this->generateUrl('teckmeb_mark_view'));
                    }
                }
            }
        }
        $em->flush();
        // Si l'ajout des notes a été fini on fait une redirection
        if (isset($form) && $form == true) {
            $this->get('teckmeb_control.control.check')->updateControlAverages($control, true);
            $request->getSession()->getFlashBag()->add('info', 'Notes bien ajoutées');
            return $this->redirectToRoute('teckmeb_control_homepage');
        }
        return $this->render('TeckmebMarkBundle::mark_edit.html.twig', array(
            'listMark' => $listMark,
            'listGroupe' => $listGroupe,
            'control' => $control,
        ));
    }

    public function editAction($id, Request $request)
    {
        // On Récupère le controle existant et on envoie le formulaire permetant de le modifier
        // Si POST alors on modifie les données dans la base de donnée
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebControlBundle:Control');
        $control = $repository->find($id);
        if (null === $control) {
            throw new NotFoundHttpException("Ce control d'id " . $id . " n'existe pas.");
        }
        if (!$this->verification($control)) {
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        $form = $this->createForm(ControlEditType::class, $control);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $control->setDivisor($control->getDivisor());
            $em->persist($control);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'DS bien modifié');
            return $this->redirectToRoute('teckmeb_control_homepage');
        }
        return $this->render('TeckmebControlBundle::edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function verificationMark($control)
    {
        if ($control->getEducation() != null) {
            return ($control->getEducation()->getTeacher()->getUser()->getId() == $this->getUser()->getId());
        } else {
            $teacher = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Teacher')->findOneByUser($this->getUser());
            $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebCoreBundle:Education');
            return (count($repository->myVerification($control, $teacher)) > 0);
        }
    }

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

    public function deleteAction($id, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux professuers.');
        }
        $em = $this->getDoctrine()->getManager();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebControlBundle:Control');
        $control = $repository->find($id);
        if (null === $control) {
            throw new NotFoundHttpException("Ce control d'id " . $id . " n'existe pas.");
        }
        if (!$this->verification($control)) {
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebMarkBundle:Mark');
        $listMark = $repository->findByControl($control);
        foreach ($listMark as $mark) {
            $em->remove($mark);
        }
        $em->remove($control);
        $em->flush();

        $request->getSession()->getFlashBag()->add('info', 'DS bien supprimé');
        return $this->redirectToRoute('teckmeb_control_homepage');
    }
}
