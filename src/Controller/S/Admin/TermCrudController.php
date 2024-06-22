<?php

namespace App\Controller\S\Admin;

use App\Entity\M\Master\Term;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class TermCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Term::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['id', 'name', 'description'])
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id', 'ID');
        $name = TextField::new('name');
        $description = TextField::new('description');
        $slug = TextField::new('slug');
        $taxonomy = TextField::new('taxonomy');
        $childs = AssociationField::new('childs');
        $parents = AssociationField::new('parents')->setFormTypeOption('by_reference', false);
        
        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $slug, $taxonomy];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $description, $slug, $taxonomy, $childs, $parents];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$id, $name, $description, $slug, $taxonomy, $childs, $parents];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$id, $name, $description, $slug, $taxonomy, $childs, $parents];
        }
    }
}
