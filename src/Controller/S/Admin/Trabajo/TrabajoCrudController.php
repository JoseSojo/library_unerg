<?php

namespace App\Controller\S\Admin\Trabajo;

use App\Entity\M\Trabajo\Trabajo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use App\Form\A\Core\DocumentType as BaseDocumentType;

class TrabajoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Trabajo::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Work')
            ->setEntityLabelInPlural('Works')
            ->setSearchFields(['title', 'content'])
            ->setPaginatorPageSize(10);
    }

    public function configureActions(Actions $actions): Actions
    {
        // $actions
        //     ->add(Crud::PAGE_INDEX, Action::DETAIL)
        //     ->remove(Crud::PAGE_INDEX, Action::NEW)
        //     // ->remove(Crud::PAGE_INDEX, Action::EDIT)
        //     ->remove(Crud::PAGE_INDEX, Action::DELETE)
        //     // ->remove(Crud::PAGE_DETAIL, Action::EDIT)
        //     ->remove(Crud::PAGE_DETAIL, Action::DELETE)
        // ;

        return parent::configureActions($actions)
            ->setPermission(Action::INDEX,'ROLE_ADMIN_WORK_LIST')
            ->setPermission(Action::DETAIL,'ROLE_ADMIN_WORK_SHOW')
            ->setPermission(Action::NEW,'ROLE_ADMIN_WORK_CREATE')
            ->setPermission(Action::EDIT,'ROLE_ADMIN_WORK_UPDATE')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $fieldsetDetails = FormField::addFieldset('User Details');

        $authorName = TextField::new('authorName')->setColumns(6);
        $authorLastname = TextField::new('authorLastname')->setColumns(6);
        $authorCi = TextField::new('authorCi')->setColumns(6);
        $authorEmail = TextField::new('authorEmail')->setColumns(6);
        $title = TextField::new('title')->setColumns(6);

        $document = ImageField::new('document')
            ->setColumns(6)
            ->setBasePath('/uploads')
            ->setUploadDir('public/uploads')
            ;

        $category = AssociationField::new('category')->setColumns(6);
        $resumen = TextareaField::new('resumen')->setColumns(12);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$title, $resumen];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$title, $resumen];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$authorName, $authorLastname, $authorCi, $authorEmail, $title, $category, $document, $resumen,
        ];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$title, $resumen];
        }
    }
}
