<?php

namespace App\Controller\S\Admin\Trabajo;

use App\Entity\M\Master\Trabajo\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

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
            ->setSearchFields(['id', 'name'])
            ->setPaginatorPageSize(10);
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions);
    }

    public function configureFields(string $pageName): iterable
    {
        $fieldsetDetails = FormField::addFieldset('User Details');

        $id = TextField::new('id')->setColumns(6)->setLabel("Identificador");
        $name = TextField::new('name')->setColumns(6)->setLabel("Nombre");
        $processorId = TextField::new('processorId')->setColumns(6)->setLabel("Id procesador");
        $enabled = Field::new('enabled')->setColumns(6)->setLabel("¿Activo?");

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $enabled];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$fieldsetDetails, $id, $name, $processorId, $enabled];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$id, $name, $processorId, $enabled];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $enabled];
        }
    }
}
