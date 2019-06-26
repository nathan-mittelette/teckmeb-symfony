<?php

namespace Teckmeb\NotificationBundle\NotificationService;

use Teckmeb\NotificationBundle\Entity\Notification;
use Teckmeb\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class NotificationService
{ 
    public $doctrine;

    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /*
        Ajout d'une notification en base de donnée
    */
    public function addNotification(User $user,$description,$href,$notsee = true,$date = null, $flush = false)
    {
        $notification = new Notification();
        $notification->setUser($user);
        $notification->setDescription($description);
        $notification->setHref($href);
        $notification->setDate(($date != null) ? $date : new \DateTime());
        $notification->setNotsee($notsee);
        $this->doctrine->persist($notification);
        if($flush)
        {
            $this->doctrine->flush();
        }
    }
}
