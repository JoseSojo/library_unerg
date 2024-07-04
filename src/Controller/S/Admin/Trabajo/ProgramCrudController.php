<?php

namespace App\Controller\S\Admin\Trabajo;

use App\Entity\M\Master\Trabajo\Program;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class ProgramCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Program::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Program')
            ->setEntityLabelInPlural('Programs')
            ->setSearchFields(['id', 'name'])
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

        $name = TextField::new('name')->setColumns(6)->setLabel("Nombre");
        $enabled = Field::new('enabled')->setColumns(6)->setLabel("¿Activo?");

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$fieldsetDetails, $name];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name];
        }
    }
}
