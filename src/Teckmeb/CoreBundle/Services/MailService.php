<?php

namespace Teckmeb\CoreBundle\Services;

use Teckmeb\UserBundle\Entity\User;

class MailService
{

    protected $swift_mail;
    protected $templating;
    protected $mail_sender;
    protected $passwordService;
    protected $userManager;

    public function __construct($swift_mail, $templating, $mail_sender, $passwordService, $userManager)
    {
        $this->swift_mail = $swift_mail;
        $this->templating = $templating;
        $this->mail_sender = $mail_sender;
        $this->passwordService = $passwordService;
        $this->userManager = $userManager;
    }

    public function addUserMail(User $user, $isTeacher, $password = null)
    {
        if ($password == null) {
            $password = $this->passwordService->getRandomPassword();
            $user->setPlainPassword($password);
            $this->userManager->updateUser($user);
        }

        if ($isTeacher) {
            $message = (new \Swift_Message("Création de votre compte sur Teckmeb"))
                ->setFrom($this->mail_sender)
                ->setTo($user->getEmailCanonical())
                ->setBody(
                    $this->templating->render(
                        "TeckmebCoreBundle:Mails:addTeacher.html.twig",
                        array("content" => $user, "password" => $password)
                    ),
                    'text/html'
                );
            $this->swift_mail->send($message);
        } else {
            /*
            $message = (new \Swift_Message("Création de votre compte sur Teckmeb"))
                ->setFrom($this->mail_sender)
                ->setTo($user->getEmailCanonical())
                ->setBody(
                    $this->templating->render(
                        "TeckmebCoreBundle:Mails:addStudent.html.twig",
                        array("content" => $user, "password" => $password)
                    ),
                    'text/html'
                );
            $this->swift_mail->send($message);
            */
        }
    }
}
