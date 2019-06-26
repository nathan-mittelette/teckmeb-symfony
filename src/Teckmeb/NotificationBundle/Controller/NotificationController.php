<?php

namespace Teckmeb\NotificationBundle\Controller;

use Teckmeb\NotificationBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Teckmeb\NotificationBundle\Form\NotificationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function postAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $repository = $em
            ->getRepository('TeckmebNotificationBundle:Notification');
        $listNotif = $repository->findBy(
            array('user' => $user),
            array('date' => 'desc'),
            5,
            0
        );
        foreach ($listNotif as $notif) {
                $notif->setNotsee(false);
                $em->persist($notif);
            }
        $em->flush();
        return new Response();
    }

    public function getAction()
    {
        $user = $this->getUser();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TeckmebNotificationBundle:Notification');
        $listNotif = $repository->findBy(
            array('user' => $user),
            array('date' => 'desc'),
            5,
            0
        );
        $tabNotif = array();
        foreach ($listNotif as $notif) {
                $tabNotif[] = array('description' => $notif->getDescription(), 'notsee' => $notif->getNotsee(), 'href' => $notif->getHref());
            }
        // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
        $response = new Response(json_encode(array('listNotif' => $tabNotif)));

        // Ici, nous définissons le Content-type pour dire au navigateur
        // que l'on renvoie du JSON et non du HTML
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function createAction(Request $request)
    {
        $notif = new Notification;
        $repository = $this->getDoctrine()->getManager()->getRepository('TeckmebUserBundle:User');
        $user = $repository->find(2);
        $notif->setUser($user);
        $notif->setNotsee(true);
        $notif->setDate(new \DateTime());
        $form = $this->get('form.factory')->create(NotificationType::class, $notif);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notif);
            $em->flush();
        }
        return $this->render('TeckmebNotificationBundle::create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
