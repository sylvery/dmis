<?php

namespace App\Form;

use App\Entity\AppUser;
use App\Entity\Treatment;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TreatmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('date', DateType::class, [
            //     'attr' => ['class'=>'form-control'],
            //     'input' => 'string',
            //     'widget' => 'single_text',
            //     'label_attr'=>['class'=>'text-muted'],
            //     'row_attr'=>['class'=>'col-md-2'],
            // ])
            ->add('client', null, [
                'attr' => ['class'=>'form-control'],
                'label_attr'=>['class'=>'text-muted'],
                'row_attr'=>['class'=>'col-md-5'],
            ])
            ->add('doctor', EntityType::class, [
                'class' => AppUser::class,
                'attr' => ['class'=>'form-control'],
                'label_attr'=>['class'=>'text-muted'],
                'row_attr'=>['class'=>'col-md-5'],
                'query_builder' => fn (EntityRepository $er) => $er->createQueryBuilder('doc')
                    // ->where("doc.roles = '[\"ROLE_DENTIST\"]'")
                    ->orderBy('doc.id', 'DESC')
                ,
            ])
            ->add('invoice', CollectionType::class, [
                'entry_type' => InvoiceType::class,
                'entry_options' => ['label' => false],
                'attr' => ['class'=>'form-control'],
                'label_attr'=>['class'=>'text-muted'],
                'row_attr'=>['class'=>'col-6'],
                'allow_add' => true,
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Treatment::class,
        ]);
    }
}
