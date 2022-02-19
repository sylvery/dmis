<?php

namespace App\Controller\Admin;

use App\Entity\Treatment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TreatmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Treatment::class;
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
