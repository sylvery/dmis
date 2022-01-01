<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Item::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $quantity = NumberField::new('quantity');
        $entries = AssociationField::new('entries');
        if (Crud::PAGE_NEW == $pageName) {
            return [$name];
        }
        if (Crud::PAGE_EDIT == $pageName) {
            return [$name, $quantity];
        }
        return [$name, $quantity, $entries];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setQuantity(0);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
