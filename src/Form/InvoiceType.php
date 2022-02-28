<?php

namespace App\Form;

use App\Entity\Invoice;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'attr' => ['class'=>'form-control'],
                'label_attr'=>['class'=>'text-muted'],
                'row_attr'=>['class'=>'col-md-6'],
                'multiple' => false,
                'expanded' => false,
                // 'query_builder' => fn (EntityRepository $er) => $er->createQueryBuilder('u')->orderBy('u.id', 'desc'),
            ])
            ->add('quantity', null, [
                'attr' => ['class'=>'form-control'],
                'label_attr'=>['class'=>'text-muted'],
                'row_attr'=>['class'=>'col-md-6'],
            ])
            ->add('discount', null, [
                'attr' => ['class'=>'form-control'],
                'label_attr'=>['class'=>'text-muted'],
                'label' => 'Discount (%)',
                'row_attr'=>['class'=>'col-md-6'],
            ])
            // ->add('treatment', null)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
