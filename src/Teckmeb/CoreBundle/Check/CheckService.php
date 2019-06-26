<?php

namespace Teckmeb\CoreBundle\Check;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManager;
use Teckmeb\CoreBundle\Entity\Controller;

class CheckService
{
    protected $listController;
    protected $listOk;
    protected $requestObj;

    public function __construct($requestObj, EntityManager $doctrine)
    {
        $this->getListOk();
        $this->requestObj = $requestObj->getCurrentRequest();
        if ($this->requestObj != null) {
            if ($this->requestObj->getSession()->get("listController") != null)
                $this->listController = $this->requestObj->getSession()->get("listController");
            else {
                $this->listController = $this->getListController($doctrine);
                $this->requestObj->getSession()->set("listController", $this->listController);
            }
        } else {
            $this->listController = $this->getListController($doctrine);
            if ($this->requestObj != null)
                $this->requestObj->getSession()->set("listController", $this->listController);
        }
    }

    public function getListOk()
    {
        $this->listOk = array();
        $arrayOk = array(array("WebProfiler", "Profiler"), array("Core", "Core"), array("User", "User"), array("Module", "Module", array("ROLE_ADMINISTRATEUR"), "Modules", "teckmeb_module_homepage"), array("Redirect", "Redirect"), array("Dashboard", "Dashboard"), array("Notification", "Notification"), array("User", "Security"), array("Administration", "Administration", array("ROLE_SECRETARIAT"), "Administration", "teckmeb_administration_homepage"), array("User", "ChangePassword"), array("User" , "Resetting"));
        foreach ($arrayOk as $ok) {
            $controller = new Controller();
            $controller->setNomBundle($ok[0]);
            $controller->setNomController($ok[1]);
            if (isset($ok[2]))
                $controller->setRoles($ok[2]);
            if (isset($ok[3]))
                $controller->setNomNavbar($ok[3]);
            if (isset($ok[4]))
                $controller->setNomRoute($ok[4]);
            $this->listOk[] = $controller;
        }
    }

    public function rightToController($controller)
    {
        if (($retourController = $this->verification($controller)) == null) {
            echo $this->getNameController($controller) . " " . $this->getNameBundle($controller);
            throw new NotFoundHttpException("Cette page n'existe pas");
        }
        $this->requestObj->getSession()->set('NomNavbar', $retourController->getNomNavbar());
    }

    private function verification($controllerEval)
    {
        $nomBundle = $this->getNameBundle($controllerEval);
        $nomController = $this->getNameController($controllerEval);
        foreach ($this->listOk as $controller) {
            if (strtolower($controller->getNomBundle()) == strtolower($nomBundle) && strtolower($controller->getNomController()) == strtolower($nomController))
                return $controller;
        }
        foreach ($this->listController as $controller) {
            if (strtolower($controller->getNomBundle()) == strtolower($nomBundle) && strtolower($controller->getNomController()) == strtolower($nomController))
                return $controller;
        }
        return null;
    }

    private function getNameController($controller)
    {
        $listClassName = explode("\\", get_class($controller));
        $controllerName = $listClassName[count($listClassName) - 1];
        return str_replace("Controller", "", $controllerName);
    }

    private function getNameBundle($controller)
    {
        $listClassName = explode("\\", get_class($controller));
        $controllerName = $listClassName[count($listClassName) - 3];
        return str_replace("Bundle", "", $controllerName);
    }

    private function getListController(EntityManager $doctrine)
    {
        $repository = $doctrine->getRepository("TeckmebCoreBundle:Controller");
        return $repository->findByValide(true);
    }

    public function getNavbarNameByRole($role)
    {
        $NomNavbar = $this->requestObj->getSession()->get("NomNavbar");
        $retour = array();
        $index = -1;
        foreach ($this->listController as $controller) {
            if (in_array($role, ($controller->getRoles() != null) ? $controller->getRoles() : array())) {
                if (strtolower($controller->getNomNavbar()) == strtolower($NomNavbar))
                    $index = count($retour);
                $retour[] = $controller;
            }
        }
        foreach ($this->listOk as $controller) {
            if ($controller->getRoles() != null) {
                if (in_array($role, $controller->getRoles())) {
                    if (strtolower($controller->getNomNavbar()) == strtolower($NomNavbar))
                        $index = count($retour);
                    $retour[] = $controller;
                }
            }
        }
        return array($retour, $index);
    }

    public function getValideForController($controllerName)
    {
        foreach ($this->listController as $controller) {
            if (strtolower($controller->getNomController()) == strtolower($controllerName)) {
                return $controller->getValide();
            }
        }
        return false;
    }
}
