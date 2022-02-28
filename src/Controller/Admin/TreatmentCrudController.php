<?php

namespace App\Controller\Admin;

use App\Entity\AppUser;
use App\Entity\Product;
use App\Entity\Treatment;
use App\Repository\AppUserRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class TreatmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Treatment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $manager = $this->getDoctrine()->getManager()->getRepository(AppUser::class);
        $prodmanager = $this->getDoctrine()->getManager()->getRepository(Product::class);
        $client = AssociationField::new('client');
        $doctor = AssociationField::new('doctor')
            ->setQueryBuilder(
                fn ($manager) => $manager->andWhere('entity.id > 0')
            )
        ;
        $product = AssociationField::new('product');
        $billings = AssociationField::new('billings');
        $date = DateField::new('date');
        $paid = BooleanField::new('paid');
        return [$date,$client,$doctor,$product,$paid];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $totalCost = 0;
        $prods = $entityInstance->getProduct();
        foreach ($prods as $prod) {
            $totalCost += $prod->getPrice();
        }
        $entityInstance->setTotalCost($totalCost);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}