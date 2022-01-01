<?php

namespace App\Controller\Admin;

use App\Entity\Entry;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class EntryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Entry::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $date = DateField::new('date');
        $amount = NumberField::new('amount');
        $quantity = IntegerField::new('quantity');
        $activity = AssociationField::new('activity');
        $item = AssociationField::new('item')
            // ->onlyOnForms()
            // ->setFormTypeOptions([
            //     "choices" => $sir->findBy(['soldOut' => false]),
            // ])
        ;
        if ($pageName == Crud::PAGE_INDEX) {
            return [$date, ArrayField::new('item'), ArrayField::new('activity'), $amount];
        }
        return [$item, $date, $amount, $quantity, $activity];
        // if ($pageName == Crud::PAGE_INDEX) {
        // } else {
            // return [];
        // }
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $item = $entityInstance->getItem();
        $activity = $entityInstance->getActivity();
        if ($activity->getName() === 'Purchase') {
            $updatedQuantity = $item->getQuantity()+$entityInstance->getQuantity();
        } else if ($activity->getName() === 'Sale') {
            $updatedQuantity = $item->getQuantity()-$entityInstance->getQuantity();
        } else {
            $updatedQuantity = 0;
        }
        $item->setQuantity($updatedQuantity);
        // dump($entityInstance); exit;
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
