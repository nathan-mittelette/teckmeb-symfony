<?php

namespace Teckmeb\QuestionBundle\Services;

use Doctrine\ORM\EntityManager;
use Teckmeb\CoreBundle\Entity\Student;
use Symfony\Component\Console\Question\Question;
use Teckmeb\UserBundle\Entity\User;
use Teckmeb\NotificationBundle\NotificationService\NotificationService;

class QuestionService
{

    protected $doctrine;

    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getQuestionsForStudent(Student $student)
    {
        return $this->doctrine
            ->getRepository('TeckmebQuestionBundle:Question')
            ->myFindQuestion($student);
    }

    public function createQuestion(Question $question, Student $student)
    {
        $question->setStudent($student);
        $groupe = $student->getCurrentGroupe();
        $question->setGroupe($groupe);
        $this->doctrine->persist($question);
    }
}
