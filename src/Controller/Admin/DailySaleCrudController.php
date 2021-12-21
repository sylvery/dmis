<?php

namespace App\Controller\Admin;

use App\Entity\DailySale;
use App\Entity\StockItem;
use App\Repository\StockItemRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class DailySaleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DailySale::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $manager = $this->getDoctrine()->getManager();;
        $sir = $manager->getRepository(StockItem::class);
        $date = DateField::new('date');
        $amount = NumberField::new('amount');
        $quantity = NumberField::new('quantity');
        $stockitem = AssociationField::new('stockItem')->onlyOnForms()->setFormTypeOptions([
            "choices" => $sir->findBy(['soldOut' => false]),
        ]);
        if ($pageName == Crud::PAGE_INDEX) {
            return [$date, ArrayField::new('stockItem'), $amount];
        }
        return [$stockitem, $date, $amount, $quantity];
        // if ($pageName == Crud::PAGE_INDEX) {
        // } else {
            // return [];
        // }
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $item = $entityInstance->getStockItem();
        $moneyExpected = $entityInstance->getQuantity() * $item->getSellingPrice();
        $moneyActual = $entityInstance->getAmount();
        // dump('persist',$entityInstance);
        // money in less than stocks sold [CR]
        if ( $moneyExpected < $moneyActual ) {
            $drd = $moneyActual - $moneyExpected;
            if ($item->getDebitedAmount()) {
                $drdAmt = $item->getDebitedAmount() + $drd;
            } else {
                $drdAmt = $drd;
            }
            $item->setDebitedAmount($drdAmt);
            // dump('DR');
        }
        // money in greater than stocks sold [DR]
        if ( $moneyExpected > $moneyActual ) {
            $crd = $moneyExpected - $moneyActual;
            if ($item->getCreditedAmount()) {
                $crdAmt = $item->getCreditedAmount() + $crd;
            } else {
                $crdAmt = $crd;
            }
            $item->setCreditedAmount($crdAmt);
            // dump('CR');
        }
        $entityManager->persist($entityInstance);
        // dump($moneyExpected, $moneyActual, $entityInstance->getQuantity());
        // exit;
        $entityManager->flush();
    }
}
