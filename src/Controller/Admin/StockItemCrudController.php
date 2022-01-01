<?php

namespace App\Controller\Admin;

use App\Entity\StockItem;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StockItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return StockItem::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $quantity = NumberField::new('quantity');
        $cost = NumberField::new('cost');
        $sellingPrice = NumberField::new('sellingPrice');
        $dateIn = DateField::new('dateIn');
        $dateOut = DateField::new('dateOut');
        $revenue = NumberField::new('revenue');
        $soldOut = BooleanField::new('soldOut');
        if ($pageName == Crud::PAGE_INDEX) {
            return [$dateIn, $name, $quantity, $cost, $soldOut];
        } else if ($pageName == Crud::PAGE_NEW) {
            return [$name, $dateIn, $quantity, $cost, $sellingPrice];
        } else if ($pageName == Crud::PAGE_EDIT) {
            $entityManager = $this->getDoctrine()->getManager();
            // dump($this->get('EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory')); exit;
            // dump($entityManager->find($this->getEntityFqcn(),16)); exit;
            $entityInstance = $entityManager->find($this->getEntityFqcn(), 16);
            if ($entityInstance) {
                return [$name, $quantity, $cost, $sellingPrice, $dateIn, $dateOut, $revenue, $soldOut];
            }
            return [$soldOut, $dateOut, $revenue, $sellingPrice];
        } else {
            return [$name, $soldOut, $quantity, $cost, $sellingPrice, $dateIn, $dateOut, $revenue];
        }
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setSoldOut(false);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
