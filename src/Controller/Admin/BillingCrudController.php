<?php

namespace App\Controller\Admin;

use App\Entity\Billing;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class BillingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Billing::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $date = DateField::new('date');
        $treatment = AssociationField::new('treatment');
        $amountPaid = NumberField::new('amountPaid');
        return [$date, $treatment, $amountPaid];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance->getAmountPaid() === $entityInstance->getTreatment()->getTotalCost()) {
            $entityInstance->getTreatment()->setPaid(true);
        }
        // dump($entityInstance); exit;
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
