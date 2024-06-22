<?php

namespace App\Controller\S\Admin;

use App\Entity\M\Core\Notifier\Mailer\Template;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MailerTemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Template::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'status', 'title', 'subject', 'locale'])
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        $id = TextField::new('id', 'ID');
        $status = TextField::new('status');
        $title = TextField::new('title');
        $subject = TextareaField::new('subject');
        $base = AssociationField::new('base');
        $header = AssociationField::new('header');
        $body = AssociationField::new('body');
        $footer = AssociationField::new('footer');
        $locale = TextField::new('locale');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $status, $title, $subject];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $status, $title, $subject, $locale, $base, $header, $body, $footer];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$id, $status, $title, $subject, $base, $header, $body, $footer];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$id, $status, $title, $subject, $base, $header, $body, $footer];
        }
    }
}
