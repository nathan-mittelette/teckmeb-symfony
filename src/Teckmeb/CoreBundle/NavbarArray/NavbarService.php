<?php

namespace Teckmeb\CoreBundle\NavbarArray;

use Symfony\Component\Security\Core\User\UserInterface;
use Teckmeb\CoreBundle\Check\CheckService;

class NavbarService
{
    public $check;

    public function __construct(CheckService $check)
    {
        $this->check = $check;
    }

    public function getArray(UserInterface $user)
    {
        return $this->check->getNavbarNameByRole($user->getRoles()[0]);
    }

    public function getValideForController($nomController)
    {
        return $this->check->getValideForController($nomController);
    }
}