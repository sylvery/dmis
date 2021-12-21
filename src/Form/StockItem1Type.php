<?php

namespace App\Form;

use App\Entity\StockItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockItem1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('quantity')
            ->add('dateIn')
            ->add('dateOut')
            ->add('cost')
            ->add('sellingPrice')
            ->add('revenue')
            ->add('creditedAmount')
            ->add('debitedAmount')
            ->add('soldOut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StockItem::class,
        ]);
    }
}
