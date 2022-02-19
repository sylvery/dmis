<?php

namespace App\Controller\Admin;

use App\Entity\Billing;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BillingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Billing::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
