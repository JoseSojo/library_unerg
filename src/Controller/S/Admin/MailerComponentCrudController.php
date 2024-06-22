<?php

namespace App\Controller\S\Admin;

use App\Entity\M\Core\Notifier\Mailer\Component;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MailerComponentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Component::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'typeComponent', 'title', 'body', 'locale'])
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title');
        $typeComponent = TextField::new('typeComponent');
        $body = TextareaField::new('body');
        $locale = TextField::new('locale');
        $id = TextField::new('id', 'ID');
        $bases = AssociationField::new('bases');
        $headers = AssociationField::new('headers');
        $bodys = AssociationField::new('bodys');
        $footers = AssociationField::new('footers');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$title, $typeComponent, $locale];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $typeComponent, $title, $body, $locale, $bases, $headers, $bodys, $footers];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$title, $typeComponent, $body, $locale];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$title, $typeComponent, $body, $locale];
        }
    }
}
