<?php

namespace App\Controller\S\Admin;

use App\Entity\M\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use Symfony\Component\Form\Extension\Core\Type\{PasswordType, RepeatedType};

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('User')
            ->setSearchFields(['username', 'email', 'roles', 'firstname', 'lastname', 'identification', 'city', 'postalCode', 'address', 'phone'])
            ->setPaginatorPageSize(10);
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions;

        return parent::configureActions($actions)
            ->setPermission(Action::INDEX,'ROLE_ADMIN_USER_LIST')
            ->setPermission(Action::DETAIL,'ROLE_ADMIN_USER_SHOW')
            ->setPermission(Action::EDIT,'ROLE_ADMIN_USER_UPDATE')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $fieldsetDetails = FormField::addFieldset('User Details');

        $firstname = TextField::new('firstname')->setColumns(6)->setLabel('Nombre');
        $lastname = TextField::new('lastname')->setColumns(6)->setLabel('Apellido');
        $username = TextField::new('username')->setColumns(6)->setLabel('Usuario');
        $identification = TextField::new('identification')->setColumns(6)->setLabel('Identificación');
        $address = TextareaField::new('address')->setColumns(12)->setLabel('Dirección');
        $groups = AssociationField::new('groups')->setColumns(6)->setLabel('Permiso');
        $enabled = Field::new('enabled')->setColumns(6)->setLabel('Activo');
        $locked = Field::new('locked')->setColumns(6)->setLabel('Bloqueado');
        $lastLogin = DateTimeField::new('lastLogin')->setColumns(6)->setLabel('Ultima sesión');
        $passwordRequestedAt = DateTimeField::new('passwordRequestedAt')->setColumns(6)->setLabel('Petición contraseña');
        $createdAt = DateTimeField::new('createdAt')->setColumns(6)->setLabel('Creado el');
        $createdBy = AssociationField::new('createdBy')->setColumns(6)->setLabel('Creado por');
        $updatedAt = DateTimeField::new('updatedAt')->setColumns(6)->setLabel('Actualizado el');
        $updatedBy = AssociationField::new('updatedBy')->setColumns(6)->setLabel('Actualizado por');
        $email = TextField::new('email')->setColumns(6)->setLabel('Correo');

        $password = TextField::new('password')
            ->setColumns(12)
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type' => PasswordType::class,
                'first_options' => [ 'label' => 'Password' ],
                'second_options' => [ 'label' => 'Repeat Password' ]
            ])
            ->setRequired($pageName === Crud::PAGE_NEW)
            ->onlyOnForms()
            ;

        if (Crud::PAGE_INDEX === $pageName) {
            return [$identification, $firstname, $lastname, $email];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$firstname, $lastname, $username, $email, $groups, $address, $enabled, $locked, $lastLogin, $passwordRequestedAt, $createdAt, $createdBy, $updatedAt, $updatedBy];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$firstname, $lastname, $username, $email, $groups, $identification, $password, $enabled, $locked, $address,];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$fieldsetDetails, $firstname, $lastname, $username, $email, $identification, $address, $groups, $enabled, $locked];
        }
    }
}
