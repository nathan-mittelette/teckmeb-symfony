<?php

namespace Teckmeb\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Teckmeb\CoreBundle\Entity\OptionController;
use Symfony\Component\HttpFoundation\Response;

class CoreController extends Controller
{

    public function updatePwdAction() {
        $userList = $this->getDoctrine()->getManager()->getRepository("TeckmebUserBundle:User")->findAll();
        foreach($userList as $user) {
            $user->setPlainPassword("imac2019*");
            $this->get("fos_user.user_manager")->updateUser($user);
        }
        return new Response("Mot de passe modifé");
    }
}
