<?php

namespace Teckmeb\ModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Teckmeb\CoreBundle\Form\ControllerType;
use Teckmeb\CoreBundle\Form\OptionControllerType;
use Teckmeb\ModuleBundle\Model\ListOption;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ModuleController extends Controller
{
    public function homeAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository("TeckmebCoreBundle:Controller");
        $listController = $repository->findBy(array("alterable" => 1));
        return $this->render('TeckmebModuleBundle::home.html.twig', array(
            'listController' => $listController
        ));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("TeckmebCoreBundle:Controller");
        $controller = $repository->find($id);
        if ($controller == null) {
            throw new NotFoundHttpException("Le controller demandé n'existe pas");
        }
        $form = $this->createForm(ControllerType::class, $controller);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($controller);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'Module bien modifié');
            return $this->redirectToRoute('teckmeb_module_homepage');
        }
        $repository = $em->getRepository("TeckmebCoreBundle:OptionController");
        $listOption = $repository->findByController($controller);
        if ($listOption != null) {
                $ListOptionObj = new ListOption($listOption);
                $formOption = $this->createForm(OptionControllerType::class, $ListOptionObj);
                if ($request->isMethod('POST') && $formOption->handleRequest($request)->isValid()) {
                    foreach ($ListOptionObj->listOption as $opt) {
                            $em->persist($opt);
                        }
                    $em->flush();
                    $request->getSession()->getFlashBag()->add('info', 'Paramètres bien modifiés');
                    return $this->redirectToRoute('teckmeb_module_homepage');
                }
            }
        return $this->render('TeckmebModuleBundle::edit.html.twig', array(
            'form' => $form->createView(),
            'controller' => $controller,
            'formOption' => isset($formOption) ? $formOption->createView() : null,
            "listOption" => $listOption
        ));
    }
}
