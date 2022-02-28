<?php

namespace App\Controller\Admin;

use App\Entity\Appointment;
use App\Entity\Billing;
use App\Entity\Client;
use App\Entity\Product;
use App\Entity\Treatment;
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
        return $this->redirect($routeBuilder->setController(AppUserCrudController::class)->generateUrl());
        // return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('HEDC Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('exit dashboard', 'fas fa-chevron-left', '/');
        yield MenuItem::linktoDashboard('AppUser', 'fas fa-user');
        yield MenuItem::linkToCrud('Appointment', 'fas fa-calendar', Appointment::class);
        yield MenuItem::linkToCrud('Billing', 'fas fa-coins', Billing::class);
        yield MenuItem::linkToCrud('Client', 'fas fa-users', Client::class);
        yield MenuItem::linkToCrud('Product', 'fas fa-box', Product::class);
        yield MenuItem::linkToCrud('Treatment', 'fas fa-newspaper', Treatment::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
