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
        $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            // ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            // ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
        ;

        return parent::configureActions($actions)
            ->setPermission(Action::INDEX,'ROLE_ADMIN_USER_LIST')
            ->setPermission(Action::DETAIL,'ROLE_ADMIN_USER_SHOW')
            ->setPermission(Action::EDIT,'ROLE_ADMIN_USER_UPDATE')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $fieldsetDetails = FormField::addFieldset('User Details');

        $firstname = TextField::new('firstname')->setColumns(6);
        $lastname = TextField::new('lastname')->setColumns(6);
        $username = TextField::new('username')->setColumns(6);
        $identification = TextField::new('identification')->setColumns(6);
        $address = TextareaField::new('address')->setColumns(6);
        $country = AssociationField::new('country')->setColumns(6);
        $groups = AssociationField::new('groups')->setColumns(6);
        $enabled = Field::new('enabled')->setColumns(6);
        $locked = Field::new('locked')->setColumns(6);
        $locale = TextField::new('locale')->setColumns(6);
        $timezone = TextField::new('timezone')->setColumns(6);
        $lastLogin = DateTimeField::new('lastLogin')->setColumns(6);
        $passwordRequestedAt = DateTimeField::new('passwordRequestedAt')->setColumns(6);
        $createdAt = DateTimeField::new('createdAt')->setColumns(6);
        $createdBy = AssociationField::new('createdBy')->setColumns(6);
        $updatedAt = DateTimeField::new('updatedAt')->setColumns(6);
        $updatedBy = AssociationField::new('updatedBy')->setColumns(6);
        $email = TextField::new('email')->setColumns(6);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$firstname, $lastname, $email, $enabled, $locked];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$firstname, $lastname, $username, $email, $identification, $address, $country, $groups, $enabled, $locked, $locale, $timezone, $lastLogin, $passwordRequestedAt, $createdAt, $createdBy, $updatedAt, $updatedBy];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$firstname, $lastname, $username, $email, $identification, $address, $country, $groups, $enabled, $locked];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$fieldsetDetails, $firstname, $lastname, $username, $email, $identification, $address, $country, $groups, $enabled, $locked];
        }
    }
}
