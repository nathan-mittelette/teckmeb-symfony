<?php

namespace Teckmeb\CoreBundle\NavbarArray;

use Symfony\Component\Security\Core\User\UserInterface;

class NavbarExtension extends \Twig_Extension
{
    public $navbarService;

    public function __construct(NavbarService $navbar)
    {
        $this->navbarService = $navbar;
    }

    public function getFunctions()
    {
      return array(
        new \Twig_SimpleFunction('getNavbarArray', array($this, 'getNavbarArray')),
        new \Twig_SimpleFunction('getValideForController' , array($this , 'getValideForController')),
      );
    }
  
    // La méthode getName() identifie votre extension Twig, elle est obligatoire
    public function getName()
    {
      return 'NavbarArray';
    }

    public function getNavbarArray(UserInterface $user)
    {
        return $this->navbarService->getArray($user);
    }

    public function getValideForController($controllerName)
    {
      return $this->navbarService->getValideForController($controllerName);
    }
}