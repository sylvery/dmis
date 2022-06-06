<?php

namespace App\Controller\Admin;

use App\Entity\AppUser;
use App\Entity\Treatment;
use App\Form\InvoiceAdminType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class TreatmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Treatment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $client = AssociationField::new('client');
        $doctor = AssociationField::new('doctor')
            // ->setQueryBuilder(
            //     fn ($manager) => $manager->andWhere('entity.id > 0')
        // )
        ;
        $invoice = AssociationField::new('invoice');
        $billings = AssociationField::new('billings');
        $date = DateField::new('date');
        $paid = BooleanField::new('paid');
        if (Crud::PAGE_NEW == $pageName OR Crud::PAGE_EDIT == $pageName) {
            return [ $date, $client, $doctor, $paid,
                CollectionField::new('invoice')
                    ->allowAdd(true)
                    ->renderExpanded(true)
                    ->setEntryIsComplex(true)
                    ->setEntryType(InvoiceAdminType::class)
            ];
        }
        return [$date, $client, $doctor, $invoice, $paid];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $totalCost = 0;
        $invoices = $entityInstance->getInvoice();
        foreach ($invoices as $invoice) {
            $subTotal = $invoice->getProduct()->getPrice() * $invoice->getQuantity();
            $discount = $subTotal * $invoice->getDiscount() / 100;
            $cost = $subTotal - $discount;
            $totalCost += $cost;
            $entityManager->persist($invoice);
        }
        $entityInstance->setTotalCost($totalCost);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
