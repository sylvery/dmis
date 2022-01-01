<?php

namespace App\Controller;

use App\Repository\EntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DailySalesController extends AbstractController
{
    /**
     * @Route("/sales/daily", name="daily_sales")
     */
    public function index(EntryRepository $er): Response
    {
        $entries = $er->findBy(['activity'=>2]);
        // dump($entries); exit;
        return $this->render('daily_sales/index.html.twig', [
            'entries' => $entries,
        ]);
    }
}
