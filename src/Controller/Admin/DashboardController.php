<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use App\Entity\Item;
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
        return $this->redirect($routeBuilder->setController(EntryCrudController::class)->generateUrl());
        // return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Table Papa');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('exit dashboard', 'fas fa-chevron-left', '/');
        yield MenuItem::linktoDashboard('Entries', 'fas fa-boxes');
        yield MenuItem::linkToCrud('Items', 'fas fa-coins', Item::class);
        yield MenuItem::linkToCrud('Activities', 'fas fa-users', Activity::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
