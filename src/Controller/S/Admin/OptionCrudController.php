<?php

namespace App\Controller\S\Admin;

use Maximosojo\ToolsBundle\Entity\Option;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class OptionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Option::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Option')
            ->setEntityLabelInPlural('Option')
            ->setSearchFields(['key', 'value', 'wrapper'])
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        $key = TextField::new('key');
        $value = TextareaField::new('value');
        $wrapper = TextField::new('wrapper');
        $id = TextField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$key, $value];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$key, $value, $wrapper, $id];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$key, $value, $wrapper];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$key, $value, $wrapper];
        }
    }
}
