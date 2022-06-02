<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud
            ->setEntityLabelInSingular('Patient')
            ->setEntityLabelInPlural('Patients')
        ;
        return $crud
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit Patient')
            ->setPageTitle(Crud::PAGE_NEW, 'Add new Patient')
            ->setPageTitle(Crud::PAGE_INDEX, 'Patient')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $gender = ChoiceField::new('gender')
            ->setChoices(function(){
                return [
                    "MALE" => "M",
                    "FEMALE" => "F",
                    "OTHER" => "O"
                ];
            })
            ->setLabel('Gender')
            ->renderExpanded(true)
            ->allowMultipleChoices(false)
        ;
        $fname = TextField::new('fname')
            ->setLabel('First Name')
        ;
        $lname = TextField::new('lname')
            ->setLabel('Last Name')
        ;
        $phone = TextField::new('phone');
        $email = TextField::new('email');
        $jobtitle = TextField::new('jobtitle')
            ->setLabel('Job Title')
        ;
        $employer = TextField::new('employer');
        $insuranceprovider = TextField::new('insuranceprovider')
            ->setLabel('Insurance Provider')
        ;
        if (Crud::PAGE_INDEX === $pageName) {
            return [TextField::new('fullname')->setLabel('Name'), $phone];
        }
        return [$fname, $lname, $gender, $phone, $email, $jobtitle, $employer, $insuranceprovider];
    }
}
