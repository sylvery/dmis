<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaleController extends AbstractController
{
    /**
     * @Route("/sale", name="sale")
     */
    public function index(): Response
    {
        // dump($this);
        return $this->render('sale/index.html.twig', [
        ]);
    }
}
