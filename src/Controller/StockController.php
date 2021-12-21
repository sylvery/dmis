<?php

namespace App\Controller;

use App\Entity\StockItem;
use App\Form\StockItem1Type;
use App\Repository\StockItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stock")
 */
class StockController extends AbstractController
{
    /**
     * @Route("/", name="stock_index", methods={"GET"})
     */
    public function index(StockItemRepository $stockItemRepository): Response
    {
        return $this->render('stock/index.html.twig', [
            'stock_items' => $stockItemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="stock_show", methods={"GET"})
     */
    public function show(StockItem $stockItem): Response
    {
        return $this->render('stock/show.html.twig', [
            'stock_item' => $stockItem,
        ]);
    }
}
