<?php

namespace App\Controller\S\Admin\Trabajo;

use App\Entity\M\Master\Trabajo\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
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
            ->setSearchFields(['name','processorId'])
            ->setPaginatorPageSize(10);
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
        return parent::configureActions($actions);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $fieldsetDetails = FormField::addFieldset('Detalles');

        $id = TextField::new('id')->setColumns(6)->setLabel("Id");
        $name = TextField::new('name')->setColumns(6)->setLabel("Nombre");
        $createdAt = DateTimeField::new('createdAt')->setColumns(6)->setLabel('Creado el');
        $updatedAt = DateTimeField::new('updatedAt')->setColumns(6)->setLabel('Actualizado el');
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $createdAt];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$fieldsetDetails, $name, $createdAt, $updatedAt];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$id, $name];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name];
        }
    }
}
