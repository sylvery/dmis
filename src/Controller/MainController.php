<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $aug;
    public function __constructor(AdminUrlGenerator $aug)
    {
        $this->aug = $aug;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        // return $this->render('main/index1.html.twig',[]);
        return $this->redirectToRoute('treatment_index');
    }
}
