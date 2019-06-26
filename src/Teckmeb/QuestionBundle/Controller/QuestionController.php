<?php

namespace Teckmeb\QuestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Teckmeb\QuestionBundle\Entity\Question;
use Teckmeb\QuestionBundle\Form\QuestionType;
use Teckmeb\QuestionBundle\Entity\Answer;
use Teckmeb\QuestionBundle\Form\AnswerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class QuestionController extends Controller
{
    public function homeAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Student');
            $user = $this->getUser();
            $student = $repository->findOneByUser($user);
            if ($student === null) {
                throw NotFoundHttpException("Les mauvaises données ont été envoyé");
            }
            $questionService = $this->get("teckmeb_question.questionService");
            $listQuestion = $questionService->getQuestionsForStudent($student);
            $question = new Question();
            $formQuestion = $this->get('form.factory')->create(QuestionType::class, $question);
            if ($request->isMethod('POST') && $formQuestion->handleRequest($request)->isValid()) {
                $questionService->createQuestion($question, $this->getUser());
                $notificationService = $this->get("teckmeb_notification.notification");
                $notificationService->addNotification($question->getTeacher()->getUser(), $student->getName() . " " . $student->getSurname() . " vous a posé une question", $this->generateUrl('teckmeb_question_homepage'));
                $this->getDoctrine()->getManager()->flush();
                $request->getSession()->getFlashBag()->add('info', 'La question a bien été posée');
                return $this->redirectToRoute('teckmeb_question_homepage');
            }
            return $this->render('TeckmebQuestionBundle::home.html.twig', array(
                'formQuestion' => $formQuestion->createView(),
                'Questions' => true,
                'listQuestion' => $listQuestion,
            ));
        } else if ($this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebCoreBundle:Teacher');
            $teacher = $repository->findOneByUser($this->getUser());
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TeckmebQuestionBundle:Question');
            $listQuestion = $repository->findByTeacher($teacher);
            return $this->render('TeckmebQuestionBundle::home.html.twig', array(
                'Questions' => true,
                'listQuestion' => $listQuestion,
            ));
        }
        throw new AccessDeniedException('Accès limité aux étudiants et professeurs.');
    }

    public function viewAction($id, Request $request)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebQuestionBundle:Question');
        $question = $repository->find($id);
        if (null === $question) {
            throw new NotFoundHttpException("Cette question d'id " . $id . " n'existe pas.");
        }
        if (!$this->verification($question)) {
            throw new AccessDeniedException('Vous n\'avez pas accès à cette question');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebQuestionBundle:Answer');

        $listAnswer = $repository->findByQuestion($question);
        $answer = new Answer();
        $formAnswer = $this->get('form.factory')->create(AnswerType::class, $answer);
        if ($request->isMethod('POST') && $formAnswer->handleRequest($request)->isValid()) {
            $answer->setUser($this->getUser());
            $answer->setQuestion($question);
            $em = $this->getDoctrine()->getManager();
            if ($question->getPublic()) {
                $notificationService = $this->get("teckmeb_notification.notification");
                $listStudent = $question->getGroupe()->getStudents();
                foreach ($listStudent as $student) {
                    if (!($answer->getUser()->getId() == $student->getUser()->getId())) {
                        $notificationService->addNotification($student->getUser(), $this->getUser()->getName() . " " . $this->getUser()->getSurname() . " a répondu", $this->generateUrl('teckmeb_question_view', array('id' => $question->getId())));
                    }
                }
            }
            $user = ($this->getUser()->getId() == $question->getTeacher()->getUser()->getId()) ? $answer->getQuestion()->getStudent()->getUser() : $question->getTeacher()->getUser();
            $notificationService->addNotification($user, $this->getUser()->getName() . " " . $this->getUser()->getSurname() . " a répondu", $this->generateUrl('teckmeb_question_view', array('id' => $question->getId())));
            $em->persist($answer);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Votre réponse a bien été enregistrée');
            return $this->redirectToRoute('teckmeb_question_homepage');
        }
        $color = ['blue darken-1', 'red darken-1', 'purple darken-1'];
        $tabColor[$question->getStudent()->getUser()->getId()] = $color[0];
        $tabAnswer = array();
        $i = 1;
        foreach ($listAnswer as $answer) {
            if (!isset($tabColor[$answer->getUser()->getId()]) && $answer->getUser()->getRoles()[0] != 'ROLE_TEACHER') {
                $tabColor[$answer->getUser()->getId()] = $color[$i];
                $i = ($i + 1) % count($color);
            }
            $tabAnswer[] = array('Color' => ($answer->getUser()->getRoles()[0] == 'ROLE_TEACHER') ? 'grey lighten-2' : $tabColor[$answer->getUser()->getId()], 'Answer' => $answer);
        }
        return $this->render('TeckmebQuestionBundle::viewQuestion.html.twig', array(
            'Questions' => true,
            'Question' => $question,
            'tabAnswer' => $tabAnswer,
            'formAnswer' => $formAnswer->createView(),
        ));
    }

    public function verification($question)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            return ($question->getTeacher()->getUser()->getId() == $this->getUser()->getId());
        } else if ($this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            return false;
        } else {
            if ($question->getPublic()) {
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TeckmebCoreBundle:Student');
                $student = $repository->findOneByUser($this->getUser());
                return ($question->getGroupe()->getStudents()->contains($student));
            } else {
                return ($question->getStudent()->getUser()->getId() == $this->getUser()->getId());
            }
        }
    }

    public function removeAction($id, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_TEACHER')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        $em = $this->getDoctrine()->getManager();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebQuestionBundle:Question');
        $question = $repository->find($id);
        if (null === $question) {
            throw new NotFoundHttpException("Cette question d'id " . $id . " n'existe pas.");
        }
        if ($question->getTeacher()->getUser()->getId() != $this->getUser()->getId()) {
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebQuestionBundle:Answer');
        $listAnswer = $repository->findByQuestion($question);
        foreach ($listAnswer as $answer) {
            $em->remove($answer);
        }
        $em->remove($question);
        $em->flush();

        $request->getSession()->getFlashBag()->add('info', 'La question a bien été supprimée');
        return $this->redirectToRoute('teckmeb_question_homepage');
    }

    public function modifyAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebQuestionBundle:Question');
        $question = $repository->find($id);
        if (null === $question) {
            throw new NotFoundHttpException("Cette question d'id " . $id . " n'existe pas.");
        }
        if ($question->getTeacher()->getUser()->getId() == $this->getUser()->getId()) {
            $question->setPublic(!$question->getPublic());
            $em->persist($question);
            $em->flush();
        } else {
            throw new AccessDeniedException('Accès limité aux professeurs.');
        }
        return $this->redirectToRoute('teckmeb_question_homepage');
    }
}
