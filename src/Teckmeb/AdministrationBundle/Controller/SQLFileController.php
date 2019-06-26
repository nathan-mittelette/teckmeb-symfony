<?php
namespace Teckmeb\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SQLFileController extends Controller
{
    public function SQLFileAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SECRETARIAT')) {
            // Sinon on déclenche une exception « Accès interdit »
            throw new AccessDeniedException('Accès limité au secretariat.');
        }
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('Europe/Paris'));
        $name = $date->format("d-m-Y-H-i") . ".sql";
        $fd = fopen("assets/sql/" . $name, "w");
        $StrSemestre = "";
        $StrPromo = "";
        $session = $request->getSession();
        $tabIDSemestre = ($session->get("tabSemestre") != null) ? $session->get("tabSemestre") : array();
        list($StrSemestre, $StrPromo) = $this->getSQLForSemestre($tabIDSemestre);
        $tabGroupeId = ($session->get("tabGroupe") != null) ? $session->get("tabGroupe") : array();
        $StrGroupe = "";
        $StrControl = "";
        $StrEducation = "";
        list($StrGroupe, $StrControl, $StrEducation) = $this->getSQLForGroupe($tabGroupeId);
        $tabStudent = ($session->get("tabStudent") != null) ? $session->get("tabStudent") : array();
        $StrTimetable = "";
        $StrMark = "";
        $StrAbsence = "";
        $StrQuestion = "";
        $StrAnwser = "";
        $StrNotification = "";
        $StrGroupeStudent = "";
        $StrUser = "";
        $StrStudent = "";
        list($StrTimetable, $StrMark, $StrAbsence, $StrQuestion, $StrAnwser, $StrNotification, $StrGroupeStudent, $StrStudent, $StrUser) = $this->getSQLForStudent($tabStudent);
        if ($StrSemestre != "") {
            fwrite($fd, "\nINSERT INTO `semestre` (`id`, `course_id`, `schoolYear`, `delay`, `semestreFullName`, `beginDate`, `endDate`) VALUES\n");
            fwrite($fd, $StrSemestre . ";\n");
            if ($StrPromo != "") {
                fwrite($fd, "\nINSERT INTO `promo` (`id`, `semestre_id`, `subject_id`, `promoName`) VALUES\n");
                fwrite($fd, $StrPromo . ";\n");
            }
        }
        if ($StrUser != "") {
            fwrite($fd, "\nINSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `name`, `surname`, `name_canonical`, `surname_canonical`) VALUES\n");
            fwrite($fd, $StrUser . ";\n");
        }
        if ($StrGroupe != "") {
            fwrite($fd, "\nINSERT INTO `groupe` (`id`, `semestre_id`, `groupFullName`, `group_name_id`) VALUES\n");
            fwrite($fd, $StrGroupe . ";");
            if ($StrControl != "") {
                fwrite($fd, "\nINSERT INTO `control` (`id`, `control_type_id`, `controlName`, `coefficient`, `divisor`, `median`, `average`, `controlDate`, `education_id`, `promo_id`) VALUES\n");
                fwrite($fd, $StrControl . ";\n");
            }
            if ($StrEducation != "") {
                fwrite($fd, "\nINSERT INTO `education` (`id`, `groupe_id`, `teacher_id`, `subject_id`, `educationName`) VALUES\n");
                fwrite($fd, $StrEducation . ";\n");
            }
        }
        if ($StrStudent != "") {
            fwrite($fd, "\nINSERT INTO `student` (`id`, `user_id`, `numStudent`) VALUES\n");
            fwrite($fd, $StrStudent . ";\n");
            if ($StrGroupeStudent != "") {
                fwrite($fd, "\nINSERT INTO `groupe_student` (`groupe_id`, `student_id`) VALUES\n");
                fwrite($fd, $StrGroupeStudent . ";\n");
            }
            if ($StrNotification != "") {
                fwrite($fd, "\nINSERT INTO `notification` (`id`, `user_id`, `description`, `date`, `href`, `notsee`) VALUES\n");
                fwrite($fd, $StrNotification . ";\n");
            }
            if ($StrQuestion != "") {
                fwrite($fd, "\nINSERT INTO `question` (`id`, `student_id`, `teacher_id`, `title`, `content`, `date`, `public`, `groupe_id`) VALUES\n");
                fwrite($fd, $StrQuestion . ";\n");
            }
            if ($StrAnwser != "") {
                fwrite($fd, "\nINSERT INTO `answer` (`id`, `user_id`, `content`, `date`, `question_id`) VALUES\n");
                fwrite($fd, $StrAnwser . ";\n");
            }
            if ($StrAbsence != "") {
                fwrite($fd, "\nINSERT INTO `absence` (`id`, `beginDate`, `endDate`, `justified`, `groupe_id`, `absence_type_id`, `student_id`) VALUES\n");
                fwrite($fd, $StrAbsence . ";\n");
            }
            if ($StrMark != "") {
                fwrite($fd, "\nINSERT INTO `mark` (`id`, `control_id`, `student_id`, `value`) VALUES\n");
                fwrite($fd, $StrMark . ";\n");
            }
            if ($StrTimetable != "") {
                fwrite($fd, "\nINSERT INTO `timetable` (`id`, `resource`, `user_id`) VALUES\n");
                fwrite($fd, $StrTimetable . ";\n");
            }
        }
        $response = new Response();
        $response->setContent(file_get_contents("assets/sql/" . $name));
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-disposition', 'filename=' . $name);
        return $response;
    }

    private function getGoodString($string)
    {
        return str_replace("\r\n", "\\r\\n", str_replace("'", "\\'", $string));
    }

    private function getSQLForStudent($tabStudent)
    {
        $StrTimetable = "";
        $StrMark = "";
        $StrAbsence = "";
        $StrQuestion = "";
        $StrAnwser = "";
        $StrNotification = "";
        $StrGroupeStudent = "";
        $StrStudent = "";
        $StrUser = "";
        foreach ($tabStudent as $studentId) {
            $student = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Student")->find($studentId);
            $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebTimeTableBundle:Timetable");
            $listTimetable = $repository->findByUser($student->getUser());
            foreach ($listTimetable as $timetable) {
                $StrTimetable = $StrTimetable . (($StrTimetable != "") ? ",\n" : "") . "(" . $timetable->getId() . ",'" . $this->getGoodString($timetable->getResource()) . "'," . $timetable->getUser()->getId() . ")";
            }
            $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebMarkBundle:Mark");
            $listMark = $repository->findByStudent($student);
            foreach ($listMark as $mark) {
                $StrMark = $StrMark . (($StrMark != "") ? ",\n" : "") . "(" . $mark->getId() . "," . $mark->getControl()->getId() . "," . $mark->getStudent()->getId() . ",'" . $this->getGoodString($mark->getValue()) . "')";
            }
            $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebAbsenceBundle:Absence");
            $listAbsence = $repository->findByStudent($student);
            foreach ($listAbsence as $absence) {
                $StrAbsence = $StrAbsence . (($StrAbsence != "") ? ",\n" : "") . "(" . $absence->getId() . ",'" . $absence->getBeginDate()->format("Y-m-d H:i:s") . "','" . $absence->getEndDate()->format("Y-m-d H:i:s") . "'," . (($absence->getJustified()) ? "1" : "0") . "," . $absence->getGroupe()->getId() . "," . $absence->getAbsenceType()->getId() . "," . $absence->getStudent()->getId() . ")";
            }
            $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebQuestionBundle:Question");
            $listQuestion = $repository->findByStudent($student);
            $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebQuestionBundle:Answer");
            foreach ($listQuestion as $question) {
                $StrQuestion = $StrQuestion . (($StrQuestion != "") ? ",\n" : "") . "(" . $question->getId() . "," . $question->getStudent()->getId() . "," . $question->getTeacher()->getId() . ",'" . $this->getGoodString($question->getTitle()) . "','" . $this->getGoodString($question->getContent()) . "','" . $question->getDate()->format("Y-m-d H:i:s") . "'," . (($question->getPublic()) ? "1" : "0") . "," . $question->getGroupe()->getId() . ")";
                $listAnwser = $repository->findByQuestion($question);
                foreach ($listAnwser as $anwser) {
                    $StrAnwser = $StrAnwser . (($StrAnwser != "") ? ",\n" : "") . "(" . $anwser->getId() . "," . $anwser->getUser()->getId() . ",'" . $this->getGoodString($anwser->getContent()) . "','" . $anwser->getDate()->format("Y-m-d H:i:s") . "'," . $anwser->getQuestion()->getId() . ")";
                }
            }
            $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebNotificationBundle:Notification");
            $listNotification = $repository->findByUser($student->getUser());
            foreach ($listNotification as $notification) {
                $StrNotification = $StrNotification . (($StrNotification != "") ? ",\n" : "") . "(" . $notification->getId() . "," . $notification->getUser()->getId() . ",'" . $this->getGoodString($notification->getDescription()) . "','" . $notification->getDate()->format("Y-m-d H:i:s") . "','" . $this->getGoodString($notification->getHref()) . "'," . (($notification->getNotsee()) ? "1" : "0") . ")";
            }
            foreach ($student->getGroupes() as $groupe) {
                $StrGroupeStudent = $StrGroupeStudent . (($StrGroupeStudent != "") ? ",\n" : "") . "(" . $groupe->getId() . "," . $student->getId() . ")";
            }
            $StrStudent = $StrStudent . (($StrStudent != "") ? ",\n" : "") . "(" . $student->getId() . "," . $student->getUser()->getId() . ",'" . $student->getNumStudent() . "')";
            $user = $student->getUser();
            $StrUser = $StrUser . (($StrUser != "") ? ",\n" : "") . "(" . $user->getId() . ",'" . $user->getUsername() . "','" . $user->getUsernameCanonical() . "','" . $user->getEmail() . "','" . $user->getEmailCanonical() . "'," . (($user->isEnabled()) ? "1" : "0") . ",'" . $user->getSalt() . "','" . $user->getPassword() . "'," . (($user->getLastLogin() != null) ? "'" . $user->getLastLogin()->format("Y-m-d H:i:s") . "'" : "NULL") . "," . (($user->getConfirmationToken() != null) ? "'" . $user->getConfirmationToken() . "'" : "NULL") . "," . (($user->getPasswordRequestedAt() != null) ? "'" . $user->getPasswordRequestedAt()->format("Y-m-d H:i:s") . "'" : "NULL") . ",'a:1:{i:0;s:" . strlen($user->getRoles()[0]) . ":\\\"" . $user->getRoles()[0] . "\\\";}','" . $user->getName() . "','" . $user->getSurname() . "','" . $user->getNameCanonical() . "','" . $user->getSurnameCanonical() . "')";
        }
        return array($StrTimetable, $StrMark, $StrAbsence, $StrQuestion, $StrAnwser, $StrNotification, $StrGroupeStudent, $StrStudent, $StrUser);
    }

    private function getSQLForGroupe($tabGroupe)
    {
        $StrGroupe = "";
        $StrControl = "";
        $StrEducation = "";
        foreach ($tabGroupe as $groupeId) {
            $groupe = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Groupe")->find($groupeId);
            $StrGroupe = $StrGroupe . (($StrGroupe != "") ? ",\n" : "") . "(" . $groupe->getId() . ", " . $groupe->getSemestre()->getId() . ",'" . $this->getGoodString($groupe->getGroupFullName()) . "', " . $groupe->getGroupName()->getId() . ")";
            $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebControlBundle:Control");
            $listControl = $repository->myFindControlGroupeBis($groupe);
            foreach ($listControl as $control) {
                $StrControl = $StrControl . (($StrControl != "") ? ",\n" : "") . "(" . $control->getId() . "," . $control->getControlType()->getId() . ",'" . $this->getGoodString($control->getControlName()) . "','" . $control->getCoefficient() . "','" . $control->getDivisor() . "'," . (($control->getMedian() != "") ? "'" . $control->getMedian() . "'" : "NULL") . "," . (($control->getAverage() != "") ? "'" . $control->getAverage() . "'" : "NULL") . ",'" . $control->getControlDate()->format("Y-m-d H:i:s") . "'," . (($control->getEducation() != null) ? "'" . $control->getEducation()->getId() . "'" : "NULL") . "," . (($control->getPromo() != null) ? "'" . $control->getPromo()->getId() . "'" : "NULL") . ")";
            }
            $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Education");
            $listEducation = $repository->findByGroupe($groupe);
            foreach ($listEducation as $education) {
                $StrEducation = $StrEducation . (($StrEducation != "") ? ",\n" : "") . "(" . $education->getId() . "," . $education->getGroupe()->getId() . "," . $education->getTeacher()->getId() . "," . $education->getSubject()->getId() . ",'" . $this->getGoodString($education->getEducationName()) . "')";
            }
        }
        return array($StrGroupe, $StrControl, $StrEducation);
    }


    private function getSQLForSemestre($tabSemestre)
    {
        $StrSemestre = "";
        $StrPromo = "";
        foreach ($tabSemestre as $semestreId) {
            $semestre = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Semestre")->find($semestreId);
            $StrSemestre = $StrSemestre . (($StrSemestre != "") ? ",\n" : "") . "(" . $semestre->getId() . ", " . $semestre->getCourse()->getId() . "," . $semestre->getSchoolYear() . ", " . (($semestre->getDelay()) ? 1 : 0) . ", '" . $this->getGoodString($semestre->getSemestreFullName()) . "', '" . $semestre->getBeginDate()->format("Y-m-d H:i:s") . "', '" . $semestre->getBeginDate()->format("Y-m-d H:i:s") . "')";
            $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Promo");
            $listPromo = $repository->findBySemestre($semestre);
            foreach ($listPromo as $promo) {
                $StrPromo = $StrPromo . (($StrPromo != "") ? ",\n" : "") . "(" . $promo->getId() . "," . $semestre->getId() . "," . $promo->getSubject()->getId() . ", '" . $this->getGoodString($promo->getPromoName()) . "')";
            }
        }
        return array($StrSemestre, $StrPromo);
    }
}
