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
        yield MenuItem::linktoDashboard('Users', 'fas fa-user');
        yield MenuItem::linkToCrud('Appointments', 'fas fa-calendar', Appointment::class);
        yield MenuItem::linkToCrud('Billing', 'fas fa-coins', Billing::class);
        yield MenuItem::linkToCrud('Patients', 'fas fa-users', Client::class);
        yield MenuItem::linkToCrud('Products', 'fas fa-box', Product::class);
        yield MenuItem::linkToCrud('Treatments', 'fas fa-newspaper', Treatment::class);
        yield MenuItem::linkToUrl('<span class="btn btn-danger text-light">exit dashboard</span>', '', '/');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
