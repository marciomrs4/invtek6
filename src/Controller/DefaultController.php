<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/",name="index")
     *
     */
    #[Route('/', name:'index', methods:['GET'])]
    public function indexAction()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/home",name="home")
     *
     */
    #[Route("/home", name:"home", methods:['GET'])]
    public function homeAction()
    {

        //return $this->render('template/home.html.twig');
        return $this->redirectToRoute('dashboard_version');
    }

    /**
     * @Route("/version",name="dashboard_version")
     * @Method("GET")
     */
    #[Route('/version', name:'dashboard_version', methods:['GET'])]
    public function versionAction()
    {

        return $this->render('Default/index.html.twig');
    }
}
