<?php

namespace App\Controller\Admin;

use App\Entity\AppUser;
use App\Entity\DailySale;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        // return $this->redirect($routeBuilder->setController(StockItemCrudController::class)->generateUrl());
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Table Papa');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('exit dashboard', 'fas fa-chevron-left', '/');
        yield MenuItem::linktoDashboard('Stocks', 'fas fa-boxes');
        // yield MenuItem::linkToCrud('Sales', 'fas fa-coins', DailySale::class);
        // yield MenuItem::linkToCrud('Users', 'fas fa-users', AppUser::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
