<?php

namespace App\Controller\Admin;

use App\Entity\AppUser;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppUserCrudController extends AbstractCrudController
{
    private $passEncInt;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->passEncInt = $userPasswordHasherInterface;
    }

    public static function getEntityFqcn(): string
    {
        return AppUser::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $email = EmailField::new('email');
        $roles = ChoiceField::new('roles')
            ->setChoices(function(){
                return [
                    "ADMINISTRATOR" => "ROLE_ADMIN",
                    "MANAGER" => "ROLE_MANAGER",
                    "DENTIST" => "ROLE_DENTIST",
                    "LAB. TECHNICIAN" => "ROLE_LABTECH"
                ];
            })
            ->setLabel('User Roles')
            ->renderExpanded(true)
            ->allowMultipleChoices(true)
        ;
        $password = TextField::new('password');
        
        return [$email, $password, $roles];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $plainPassword = $entityInstance->getPassword();
        $encPass = $this->passEncInt->hashPassword($this->getUser(),$plainPassword);
        $entityInstance->setPassword($encPass);
        // dump($entityInstance); exit;
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $plainPassword = $entityInstance->getPassword();
        $encPass = $this->passEncInt->hashPassword($this->getUser(),$plainPassword);
        $entityInstance->setPassword($encPass);
        // dump($entityInstance); exit;
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
