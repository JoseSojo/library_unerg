<?php

namespace App\Controller\S\Admin\Trabajo;

use App\Entity\M\Master\Trabajo\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Category')
            ->setEntityLabelInPlural('Categories')
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
            // ->setPermission(Action::INDEX,'ROLE_ADMIN_WORK_CATEOGRY_LIST')
            // ->setPermission(Action::DETAIL,'ROLE_ADMIN_WORK_CATEOGRY_SHOW')
            // ->setPermission(Action::NEW,'ROLE_ADMIN_WORK_CATEOGRY_CREATE')
            // ->setPermission(Action::EDIT,'ROLE_ADMIN_WORK_CATEOGRY_UPDATE')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        $fieldsetDetails = FormField::addFieldset('User Details');

        $id = TextField::new('id')->setColumns(6);
        // $createAt = DateTimeField::new('createAt')->setColumns(6);
        // $updateAt = DateTimeField::new('updateAt')->setColumns(6);
        $name = TextField::new('name')->setColumns(6);
        $processorId = TextField::new('processorId')->setColumns(6);
        $enabled = Field::new('enabled')->setColumns(6);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $enabled];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $processorId, $enabled];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$id, $name, $processorId, $enabled];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $enabled];
        }
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
