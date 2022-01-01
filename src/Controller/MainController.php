<?php

namespace App\Controller;

use App\Controller\Admin\DailySaleCrudController;
use App\Controller\Admin\StockItemCrudController;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\ItemRepository;
use App\Repository\LibrarianRepository;
use App\Repository\StockItemRepository;
use App\Repository\StudentRepository;
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
    public function index(ItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findAll();
        // $stocksSoldOut = $sir->findBy(['soldOut'=>true],['dateOut'=>'desc']);
        // $stocksSelling = $sir->findBy(['soldOut'=>false],['dateIn'=>'desc']);
        // $totalCosts = 0;
        // $totalRevenue = 0;
        // foreach ($stocks as $stock) {
        //     $totalCosts += $stock->getCost();
        //     $totalRevenue += $stock->getRevenue();
        // }
        // dump($addNewDailySalesRecordUrl, $addNewStockItemUrl); exit;
        return $this->render('main/index1.html.twig',[
            'items' => $items,
            // 'stocksSoldOut' => $stocksSoldOut,
            // 'stocksSelling' => $stocksSelling,
            // 'totalCosts' => $totalCosts,
            // 'totalRevenue' => $totalRevenue,
        ]);
    }
}
