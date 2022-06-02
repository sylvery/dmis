<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3 col-md-3 col-sm-6'],
            ])
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3 col-md-3 col-sm-6'],
            ])
            ->add('client', EntityType::class, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3 col-md-6 col-sm-6'],
                'class' => Client::class,
            ])
            ->add('description', CKEditorType::class, [
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3 col-12'],
            ])
            // ->add('noshow', ChoiceType::class, [
            //     'attr' => ['class' => 'form-control'],
            // 'row_attr' => ['class' => 'mb-3 col-3'],
            //     'multiple' => false,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
