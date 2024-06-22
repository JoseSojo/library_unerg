<?php

namespace App\Controller\S\Admin;

use App\Entity\M\OAuth2\Client;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AuthClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['randomId', 'redirectUris', 'secret', 'scopes', 'id', 'createdIp', 'updatedIp'])
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        $scopes = ArrayField::new('scopes');
        $active = Field::new('active');
        $name = TextField::new('name');
        $randomId = TextField::new('randomId');
        $redirectUris = ArrayField::new('redirectUris');
        $secret = TextField::new('secret');
        $id = IntegerField::new('id', 'ID');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $createdIp = TextField::new('createdIp');
        $updatedIp = TextField::new('updatedIp');
        $publicId = TextareaField::new('publicId');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $publicId, $secret, $scopes, $active];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$name, $randomId, $redirectUris, $secret, $scopes, $id, $active, $createdAt, $updatedAt, $createdIp, $updatedIp];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $scopes, $active];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $scopes, $active];
        }
    }
}
