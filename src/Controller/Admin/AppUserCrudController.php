<?php

namespace App\Controller\Admin;

use App\Entity\AppUser;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AppUserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AppUser::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            ArrayField::new('roles'),
            TextField::new('password'),
        ];
    }
}
